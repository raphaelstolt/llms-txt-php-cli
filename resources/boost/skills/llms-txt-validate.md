---
id: llms-txt-validate
name: "Validate llms.txt"
description: "Validate an existing llms.txt with llms-txt-php-cli and guide the user through fixing validation errors."
tooling:
- "llms-txt-php-cli"
  entrypoint_hints:
- "bin/llms-txt-cli validate"
  tags:
- "llms.txt"
- "cli"
- "validation"
---

## Goal
Run validation for `llms.txt`, interpret failures, and propose minimal edits that make it pass.

## Steps
1. Run:
    - `php bin/llms-txt-cli validate`
2. If it fails:
    - Ask the user to paste the full output.
    - Identify whether the issue is:
        - formatting / schema rules
        - missing file
        - invalid link
        - encoding / newline issues
3. Propose a minimal patch:
    - Keep the existing structure unless the validator explicitly requires changes.
4. Re-run `validate` until clean.

## What to preserve
- User’s existing content and ordering unless required.
- Project-specific URLs and descriptions.

## Example diagnostics prompts
- “Paste the validator output; I’ll map each error to the exact line/section to fix.”
- “If this is Windows + Git autocrlf, we may need to normalize line endings.”
