#!/usr/bin/env bash
#
# Stage restwell-theme changes, commit on main, and push to origin/main.
#
# Usage (from repo root):
#   ./restwell-theme/scripts/local/commit-push-main.sh -m "feat(theme): short description"
#   ./restwell-theme/scripts/local/commit-push-main.sh "feat(theme): short description"
#   ./restwell-theme/scripts/local/commit-push-main.sh -m "..." --all   # stage entire repo
#   ./restwell-theme/scripts/local/commit-push-main.sh -m "..." --dry-run
#
set -euo pipefail

THEME_DIR="restwell-theme"
DRY_RUN=0
STAGE_ALL=0
MESSAGE=""

usage() {
	cat <<'EOF'
Usage: commit-push-main.sh -m "commit message" [options]
       commit-push-main.sh "commit message" [options]

Options:
  -m, --message TEXT   Commit message (required)
  -a, --all            Stage all repo changes (default: restwell-theme/ only)
  -n, --dry-run        Show what would run without committing or pushing
  -h, --help           Show this help

Runs from any directory inside the git repository. Refuses to run unless
the current branch is main.
EOF
	exit "${1:-0}"
}

while [[ $# -gt 0 ]]; do
	case "$1" in
		-h | --help) usage 0 ;;
		-m | --message)
			shift
			[[ $# -gt 0 ]] || {
				echo "Missing value for $1" >&2
				exit 1
			}
			MESSAGE="$1"
			;;
		-a | --all) STAGE_ALL=1 ;;
		-n | --dry-run) DRY_RUN=1 ;;
		-*) echo "Unknown option: $1" >&2; usage 1 ;;
		*)
			if [[ -n "$MESSAGE" ]]; then
				echo "Unexpected argument: $1" >&2
				exit 1
			fi
			MESSAGE="$1"
			;;
	esac
	shift
done

[[ -n "$MESSAGE" ]] || {
	echo "Commit message is required. Use -m or pass it as the first argument." >&2
	usage 1
}

need_cmd() {
	command -v "$1" >/dev/null 2>&1 || {
		echo "Required command not found: $1" >&2
		exit 1
	}
}

need_cmd git

REPO_ROOT="$(git rev-parse --show-toplevel 2>/dev/null)" || {
	echo "Not inside a git repository." >&2
	exit 1
}

cd "$REPO_ROOT"

BRANCH="$(git branch --show-current)"
if [[ "$BRANCH" != "main" ]]; then
	echo "Refusing to commit: current branch is '$BRANCH' (expected 'main')." >&2
	exit 1
fi

run() {
	if [[ "$DRY_RUN" -eq 1 ]]; then
		printf '+'
		printf ' %q' "$@"
		printf '\n'
	else
		"$@"
	fi
}

if [[ "$DRY_RUN" -eq 1 ]]; then
	echo "--- changes that would be staged ---"
	if [[ "$STAGE_ALL" -eq 1 ]]; then
		run git add -n -A
	else
		if [[ ! -d "$THEME_DIR" ]]; then
			echo "Theme directory not found: $REPO_ROOT/$THEME_DIR" >&2
			exit 1
		fi
		run git add -n -A "$THEME_DIR/"
	fi
	if [[ -z "$(git status --porcelain)" ]]; then
		echo "Nothing to commit." >&2
		exit 1
	fi
	git status --short
	run git commit -m "$MESSAGE"
	run git push origin main
	exit 0
fi

if [[ "$STAGE_ALL" -eq 1 ]]; then
	run git add -A
	run git reset -- scripts/__pycache__/ "${THEME_DIR}/scripts/__pycache__/" 2>/dev/null || true
else
	if [[ ! -d "$THEME_DIR" ]]; then
		echo "Theme directory not found: $REPO_ROOT/$THEME_DIR" >&2
		exit 1
	fi
	run git add -A "$THEME_DIR/"
	run git reset -- "${THEME_DIR}/scripts/__pycache__/" 2>/dev/null || true
fi

if git diff --cached --quiet; then
	echo "Nothing staged to commit." >&2
	git status --short
	exit 1
fi

git commit -m "$MESSAGE"
git push origin main

echo "Pushed to origin/main ($(git rev-parse --short HEAD))."
