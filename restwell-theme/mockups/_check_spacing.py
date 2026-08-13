#!/usr/bin/env python3
"""Enforce spacing-system governance rules for mockups/shared.css.

Rules (see SPACING SYSTEM comment in shared.css):
  A. Every non-ladder --rhythm-* token needs a justification comment.
  B. Component rules consume tokens only (literal whitelist applies).
  C. @media blocks remap tokens — never spacing-property literals.

Exit 0 when clean, 1 when violations are found.
"""

from __future__ import annotations

import argparse
import re
import sys
from pathlib import Path

ROOT = Path(__file__).resolve().parent
DEFAULT_CSS = ROOT / "shared.css"

SPACING_PROP_RE = re.compile(
    r"^(?P<prop>"
    r"padding(?:-(?:top|right|bottom|left|inline|block|inline-start|inline-end|block-start|block-end))?"
    r"|margin(?:-(?:top|right|bottom|left|inline|block|inline-start|inline-end|block-start|block-end))?"
    r"|scroll-(?:margin|padding)(?:-(?:top|right|bottom|left|inline|block))?"
    r"|(?:row-|column-)?gap"
    r"|inset(?:-(?:block|inline)(?:-(?:start|end))?)?"
    r"|top|right|bottom|left"
    r")\s*:",
    re.IGNORECASE,
)

CUSTOM_PROP_RE = re.compile(r"^--[a-z0-9-]+\s*:", re.IGNORECASE)
RHYTHM_DEF_RE = re.compile(r"^(?P<name>--rhythm-[a-z0-9-]+)\s*:", re.IGNORECASE)
LADDER_STEP_RE = re.compile(r"--rhythm-.+-[0123]$", re.IGNORECASE)
LENGTH_RE = re.compile(
    r"(?<![\w.-])(?P<sign>[-+]?)(?P<num>\d+(?:\.\d+)?)(?P<unit>rem|px|em)\b",
    re.IGNORECASE,
)
COMMENT_RE = re.compile(r"/\*.*?\*/", re.DOTALL)
ROOT_SEL_RE = re.compile(r"(?:^|[,\s]):root\b")


def strip_strings(text: str) -> str:
    return re.sub(r'"[^"]*"|\'[^\']*\'', '""', text)


def is_ladder_step(name: str) -> bool:
    return bool(LADDER_STEP_RE.match(name))


def has_comment(line: str) -> bool:
    return "/*" in line


def previous_nonblank(lines: list[str], index: int) -> str | None:
    i = index - 1
    while i >= 0:
        if lines[i].strip():
            return lines[i]
        i -= 1
    return None


def is_whitelisted_length(num: str, unit: str) -> bool:
    """Optical nudges / hairlines — see Rule B whitelist."""
    value = float(num)
    unit = unit.lower()
    if unit == "px":
        return value < 4
    if unit == "rem":
        return value < 0.25
    if unit == "em":
        # Font-relative optical alignment — not page rhythm
        return True
    return False


def spacing_literals(value: str) -> list[tuple[str, str]]:
    return [(m.group("num"), m.group("unit")) for m in LENGTH_RE.finditer(value)]


def declaration_violates(value: str, line: str) -> bool:
    literals = spacing_literals(value)
    if not literals:
        return False
    if all(is_whitelisted_length(n, u) for n, u in literals):
        return False
    # Fixed-chrome waiver: any inline comment on the declaration line
    if has_comment(line):
        return False
    return True


def parse_css(text: str) -> list[dict]:
    """Walk the file; track whether each line is inside :root and/or @media."""
    lines = text.splitlines()
    results: list[dict] = []
    depth = 0
    in_root = False
    in_media = False
    media_depth = None
    root_depth = None
    in_block_comment = False

    for i, raw in enumerate(lines):
        code_chars: list[str] = []
        j = 0
        while j < len(raw):
            if in_block_comment:
                end = raw.find("*/", j)
                if end == -1:
                    break
                j = end + 2
                in_block_comment = False
                continue
            start = raw.find("/*", j)
            if start == -1:
                code_chars.append(raw[j:])
                break
            code_chars.append(raw[j:start])
            end = raw.find("*/", start + 2)
            if end == -1:
                in_block_comment = True
                break
            j = end + 2

        scan = strip_strings("".join(code_chars))
        stripped_code = scan.strip()
        sel_src = stripped_code.rstrip().rstrip("{").strip()
        opens_media = sel_src.startswith("@media")
        opens_root = bool(ROOT_SEL_RE.search(sel_src)) or sel_src == ":root"

        opens = scan.count("{")
        closes = scan.count("}")

        line_in_root = in_root
        line_in_media = in_media

        if opens:
            for _ in range(opens):
                depth += 1
                if opens_media and media_depth is None:
                    in_media = True
                    media_depth = depth
                    opens_media = False
                if opens_root and root_depth is None:
                    in_root = True
                    root_depth = depth
                    opens_root = False
            line_in_root = in_root
            line_in_media = in_media

        results.append(
            {
                "line_no": i + 1,
                "text": raw,
                "in_root": line_in_root,
                "in_media": line_in_media,
            }
        )

        if closes:
            for _ in range(closes):
                if media_depth is not None and depth == media_depth:
                    in_media = False
                    media_depth = None
                if root_depth is not None and depth == root_depth:
                    in_root = False
                    root_depth = None
                depth = max(0, depth - 1)

    return results


def check_file(path: Path) -> list[str]:
    text = path.read_text(encoding="utf-8")
    lines = text.splitlines()
    parsed = parse_css(text)
    violations: list[str] = []
    rel = path.name

    for entry in parsed:
        line_no = entry["line_no"]
        raw = entry["text"]
        stripped = raw.strip()
        if not stripped:
            continue

        code_part = COMMENT_RE.sub("", stripped).strip()
        if not code_part:
            continue

        # --- Check A: --rhythm-* justification ---
        m = RHYTHM_DEF_RE.match(code_part)
        if m:
            name = m.group("name")
            if not is_ladder_step(name):
                same = has_comment(raw)
                prev = previous_nonblank(lines, line_no - 1)
                prev_ok = bool(prev and has_comment(prev))
                if not same and not prev_ok:
                    violations.append(
                        f"{rel}:{line_no}: A {name} needs a justification comment "
                        f"(why no existing role fits)"
                    )

        # Custom property definitions are token homes — not Rule B/C consumers
        if CUSTOM_PROP_RE.match(code_part):
            continue

        # Values live in :root; literals there define the scale
        if entry["in_root"]:
            continue

        prop_match = SPACING_PROP_RE.match(code_part)
        if not prop_match:
            continue

        value = code_part.split(":", 1)[1].rstrip(";").strip()
        if not declaration_violates(value, raw):
            continue

        prop = prop_match.group("prop")
        if entry["in_media"]:
            violations.append(
                f"{rel}:{line_no}: C @media must remap tokens, not set "
                f"{prop} with a length literal "
                f"(whitelist: <0.25rem/<4px/em optical, or /* waiver */)"
            )
        else:
            violations.append(
                f"{rel}:{line_no}: B component rules must consume tokens for "
                f"{prop} "
                f"(whitelist: <0.25rem/<4px/em optical, or /* waiver */)"
            )

    return violations


def main(argv: list[str] | None = None) -> int:
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument(
        "css",
        nargs="?",
        type=Path,
        default=DEFAULT_CSS,
        help=f"CSS file to check (default: {DEFAULT_CSS.name})",
    )
    parser.add_argument(
        "--quiet",
        action="store_true",
        help="Only print violations (no summary line)",
    )
    args = parser.parse_args(argv)

    path = args.css.resolve() if args.css.is_absolute() else (Path.cwd() / args.css).resolve()
    if not path.is_file() and args.css.name == DEFAULT_CSS.name:
        path = DEFAULT_CSS
    if not path.is_file():
        print(f"error: CSS file not found: {args.css}", file=sys.stderr)
        return 2

    violations = check_file(path)
    for v in violations:
        print(v)

    if not args.quiet:
        if violations:
            print(f"spacing check: {len(violations)} violation(s) in {path.name}")
        else:
            print(f"spacing check: ok ({path.name})")

    return 1 if violations else 0


if __name__ == "__main__":
    sys.exit(main())
