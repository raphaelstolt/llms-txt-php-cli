---
id: llms-txt-init
name: "Initialise llms.txt"
description: "Guide the user to generate an initial llms.txt for a repository using llms-txt-php-cli, choosing sensible defaults and verifying output."
tooling:
- "llms-txt-php-cli"
  entrypoint_hints:
- "bin/llms-txt-cli init"
  tags:
- "llms.txt"
- "cli"
- "init"
---

## Goal
Help the user create an initial `llms.txt` file in their repository using `llms-txt-php-cli`, then sanity-check that it’s usable.

## What you should ask first (if missing)
1. Repository root path (or confirm we are in repo root).
2. Whether they want to include private/internal docs (default: no).
3. Whether they want to include links to READMEs / docs folders (default: yes).

## Steps
1. Ensure the command is available:
    - Prefer running the project-local binary: `php bin/llms-txt-cli ...` (or `./bin/llms-txt-cli ...` on Unix).
2. Run init:
    - `php bin/llms-txt-cli init`
3. Verify that `llms.txt` was created/updated.
4. Immediately run validation:
    - `php bin/llms-txt-cli validate`
5. If validation fails, explain the error and propose the smallest fix.

## Output expectations
- A `llms.txt` file exists at repo root (unless the user chose another path).
- `validate` succeeds.

## Common pitfalls
- Running from the wrong working directory (repo root matters).
- Line endings differences on Windows: keep the file UTF-8, LF preferred if your repo enforces it.

## Example
User: “Create an llms.txt for my project.”
Assistant:
- “From the repository root, run `php bin/llms-txt-cli init`, then `php bin/llms-txt-cli validate` and paste any errors.”
