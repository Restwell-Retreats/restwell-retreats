#!/usr/bin/env bash
# Prepend archive banner and move SEO markdown to docs/archive/seo-legacy/
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/../.." && pwd)"
ARCHIVE="$ROOT/docs/archive/seo-legacy"
DATE="2026-07-05"

banner() {
  cat <<EOF
> **Archived ${DATE}.** Superseded by [\`restwell-theme/SEO-INTENT-ONPAGE-PLAN.md\`](../restwell-theme/SEO-INTENT-ONPAGE-PLAN.md) (site SEO SSOT), [\`FRONT-PAGE-OPTIMIZATION.md\`](../FRONT-PAGE-OPTIMIZATION.md) (homepage), and/or [\`restwell-theme/AUDIT.md\`](../restwell-theme/AUDIT.md). Open work: SSOT §11.6 / §16 and AUDIT sprint plan. Do not execute tasks from this file.

EOF
}

move_with_banner() {
  local src="$1" dest="$2"
  if [[ ! -f "$src" ]]; then
    echo "SKIP (missing): $src"
    return 0
  fi
  mkdir -p "$(dirname "$dest")"
  { banner; cat "$src"; } > "$dest"
  rm "$src"
  echo "Archived: $src -> $dest"
}

# legacy-strategy
for f in restwell-seo-section1.md restwell-seo-sections2-4.md restwell-seo-sections5-7.md restwell-seo-sections8-11.md; do
  move_with_banner "$ROOT/$f" "$ARCHIVE/legacy-strategy/$f"
done

# homepage
move_with_banner "$ROOT/front-page-seo-optimization.md" "$ARCHIVE/homepage/front-page-seo-optimization.md"
move_with_banner "$ROOT/homepage-seo-cro-plan.md" "$ARCHIVE/homepage/homepage-seo-cro-plan.md"
move_with_banner "$ROOT/front-page-polish.md" "$ARCHIVE/homepage/front-page-polish.md"
move_with_banner "$ROOT/restwell-theme/HOMEPAGE-PIPELINE-DELIVERABLE.md" "$ARCHIVE/homepage/HOMEPAGE-PIPELINE-DELIVERABLE.md"

# audit-sprints
move_with_banner "$ROOT/audit-90-all-domains.md" "$ARCHIVE/audit-sprints/audit-90-all-domains.md"
move_with_banner "$ROOT/high-priority-audit-remediation.md" "$ARCHIVE/audit-sprints/high-priority-audit-remediation.md"
move_with_banner "$ROOT/critical-audit-fixes.md" "$ARCHIVE/audit-sprints/critical-audit-fixes.md"
move_with_banner "$ROOT/restwell-theme/PERFECT-SITE-PLAN.md" "$ARCHIVE/audit-sprints/PERFECT-SITE-PLAN.md"

# prompt-stubs
move_with_banner "$ROOT/audit.md" "$ARCHIVE/prompt-stubs/audit.md"
move_with_banner "$ROOT/restwell-theme/seo-admin-cpt.md" "$ARCHIVE/prompt-stubs/seo-admin-cpt.md"
move_with_banner "$ROOT/restwell-theme/PAGE-RUNS.md" "$ARCHIVE/prompt-stubs/PAGE-RUNS.md"

echo "Done."
