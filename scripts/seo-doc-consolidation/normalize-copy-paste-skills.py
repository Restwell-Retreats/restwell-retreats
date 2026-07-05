#!/usr/bin/env python3
"""Normalize COPY-PASTE-PROMPTS.md skill refs to /skill-name only."""

import re
from pathlib import Path

ROOT = Path(__file__).resolve().parents[2]
path = ROOT / "restwell-theme" / "COPY-PASTE-PROMPTS.md"
text = path.read_text(encoding="utf-8")

# @/Users/.../skills/.../foo/SKILL.md or skills/foo/SKILL.md -> /foo
text = re.sub(
    r"@?/Users/elliesmith/\.cursor/skills/(?:skills/)?([a-z0-9-]+)/SKILL\.md",
    r"/\1",
    text,
)
# /skill @/path... -> /skill
text = re.sub(
    r"(/[\w-]+)\s+@/Users/elliesmith/\.cursor/skills/[^\s]+",
    r"\1",
    text,
)
# /seo-meta-optimizer /wordpress-theme-classic-meta @... @... -> both slash names
text = re.sub(
    r"/seo-meta-optimizer\s+/wordpress-theme-classic-meta\s+@[^\n]+",
    "/seo-meta-optimizer /wordpress-theme-classic-meta",
    text,
)
# seo-content-auditor + seo-authority-builder with paths
text = re.sub(
    r"@/Users/elliesmith/\.cursor/skills/[^\n]+/seo-content-auditor/SKILL\.md\s+/seo-content-auditor\s+\+\s+/seo-authority-builder\s+@/Users/elliesmith/\.cursor/skills/[^\n]+/seo-authority-builder/SKILL\.md",
    "/seo-content-auditor + /seo-authority-builder",
    text,
)
text = re.sub(
    r"/seo-content-auditor\s+\+\s+/seo-authority-builder\s+@/Users/elliesmith/\.cursor/skills/[^\n]+",
    "/seo-content-auditor + /seo-authority-builder",
    text,
)
# Run site-wide block
text = re.sub(
    r"Run /seo-audit @/Users/elliesmith/\.cursor/skills/[^\n]+",
    "Run /seo-audit",
    text,
)
text = re.sub(
    r"Run @/Users/elliesmith/\.cursor/skills/visual-frontend-audit/SKILL\.md /visual-frontend-audit",
    "Run /visual-frontend-audit",
    text,
)
text = re.sub(
    r"@\.cursor/skills/restwell-page-polish/SKILL\.md /restwell-page-polish",
    "/restwell-page-polish",
    text,
)

header = (
    "**Paths:** `@restwell-theme/` = this theme folder. "
    "Invoke skills via **`/skill-name`** — see [SKILLS_GLOSSARY.md](SKILLS_GLOSSARY.md).\n"
)
text = re.sub(
    r"\*\*Paths:\*\* `@restwell-theme/` = this theme folder\. Skill names: see \[SKILLS_GLOSSARY\.md\]\(SKILLS_GLOSSARY\.md\) \(`/skill-name`\); legacy absolute paths below still work\.\n",
    header,
    text,
)

if "/Users/elliesmith/.cursor/skills" in text:
    raise SystemExit("Still has absolute skill paths")

path.write_text(text, encoding="utf-8")
print(f"Normalized {path}")
