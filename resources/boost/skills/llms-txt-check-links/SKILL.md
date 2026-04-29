---
id: llms-txt-check-links
name: "Check links referenced by llms.txt"
description: "Run link checking for URLs in llms.txt and help the user fix broken or redirected links."
tooling:
- "llms-txt-php-cli"
  entrypoint_hints:
- "bin/llms-txt-cli check-links"
  tags:
- "llms.txt"
- "cli"
- "links"
---

## Goal
Check that links referenced in `llms.txt` are reachable, then fix any broken ones with minimal changes.

## Steps
1. Run:
    - `php bin/llms-txt-cli check-links`
2. If failures occur:
    - Group them:
        - 404/410: update/remove link
        - 301/302: decide whether to pin final URL
        - timeout: retry; consider network/proxy
3. Fix strategy
    - Prefer HTTPS where available.
    - Prefer stable canonical docs URLs over volatile branch URLs.
    - If a link is intentionally private/unreachable, suggest removing it or marking it appropriately (without inventing nonstandard syntax).

## Ask for context when needed
- Is the repo public or private?
- Are links intranet-only?
- Are CI runners allowed outbound internet?

## Example
User: “CI fails on check-links.”
Assistant:
- “Paste the check-links output; I’ll propose the smallest edit(s) to llms.txt to make all URLs pass.”
