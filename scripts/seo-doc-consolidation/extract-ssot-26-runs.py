#!/usr/bin/env python3
"""Extract §2.6 evidence runs from SSOT to docs/seo-runs/."""

from pathlib import Path

ROOT = Path(__file__).resolve().parents[2]
SSOT = ROOT / "restwell-theme" / "SEO-INTENT-ONPAGE-PLAN.md"
RUNS_DIR = ROOT / "docs" / "seo-runs"
RUNS_FILE = RUNS_DIR / "2026-05-10-evidence-runs.md"

lines = SSOT.read_text(encoding="utf-8").splitlines(keepends=True)

# Find ### 2.6 and ## 3. Topic cluster
start = end = None
for i, line in enumerate(lines):
    if line.startswith("### 2.6 Agent keyword"):
        start = i
    if start is not None and line.startswith("## 3. Topic cluster"):
        end = i
        break

if start is None or end is None:
    raise SystemExit("Could not find §2.6 boundaries")

# Keep intro through canonical runs index (lines before first #### Run)
intro_end = start
for i in range(start, end):
    if lines[i].startswith("#### Run -"):
        intro_end = i
        break

intro = "".join(lines[start:intro_end])
runs_body = "".join(lines[intro_end:end])

RUNS_DIR.mkdir(parents=True, exist_ok=True)
RUNS_FILE.write_text(
    "# §2.6 evidence runs — 2026-05-10 batch\n\n"
    "Extracted from `SEO-INTENT-ONPAGE-PLAN.md` on 2026-07-05. "
    "Append new runs here (dated files) or add a new `YYYY-MM-DD-*.md` under `docs/seo-runs/`.\n\n"
    + runs_body,
    encoding="utf-8",
)

index_block = (
    intro
    + "\n**Evidence run archive (extracted 2026-07-05):** Full `#### Run - …` subsections live in "
    "[`docs/seo-runs/2026-05-10-evidence-runs.md`](../../docs/seo-runs/2026-05-10-evidence-runs.md). "
    "Append **new** runs to that file or create `docs/seo-runs/YYYY-MM-DD-<topic>.md` and add a row below.\n\n"
    "| Batch | File | URLs covered |\n"
    "|-------|------|-------------|\n"
    "| 2026-05-10 evidence pass | [2026-05-10-evidence-runs.md](../../docs/seo-runs/2026-05-10-evidence-runs.md) | All §2.6 runs through blog hub |\n\n"
    "*Do not duplicate tier tables here — edit the archive file and summarize deltas in a one-line note if needed.*\n\n"
)

new_lines = lines[:start] + [index_block] + lines[end:]
SSOT.write_text("".join(new_lines), encoding="utf-8")
print(f"Extracted {end - intro_end} lines to {RUNS_FILE}")
print(f"SSOT now {len(new_lines)} lines")
