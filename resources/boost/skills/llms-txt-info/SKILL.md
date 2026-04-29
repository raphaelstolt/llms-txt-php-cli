---
id: llms-txt-info
name: "Explain llms-txt-php-cli status/info"
description: "Use the CLI info command to summarize what llms-txt-php-cli detects/configures for the current repository."
tooling:
- "llms-txt-php-cli"
  entrypoint_hints:
- "bin/llms-txt-cli info"
  tags:
- "llms.txt"
- "cli"
- "info"
---

## Goal
Help the user understand what the tool sees in their repo and what actions to take next (init, validate, check-links).

## Steps
1. Run:
    - `php bin/llms-txt-cli info`
2. Summarize:
    - Whether `llms.txt` exists
    - Recommended next command(s)
3. If the user wants improvements:
    - Suggest `init` (if missing), then `validate`, then `check-links`.

## Output style
- Short bullet list
- Actionable next steps

## Example
User: “What should I run first?”
Assistant:
- “Run `php bin/llms-txt-cli info` and share the output; I’ll tell you the shortest path to green validation.”
