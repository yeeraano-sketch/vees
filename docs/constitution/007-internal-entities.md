# 007 — Internal Entities

Status

ACTIVE

---

## Intent

Complex Aggregates may be internally decomposed into Entities.

Internal Entities never become separate Aggregates.

---

## Rules

- Every Internal Entity belongs to exactly one Aggregate Root.
- Internal Entities have identity only inside their Aggregate.
- Internal Entities are never referenced from another Context.
- Aggregate Root is the only public entry point.

---

## Consequences

- Prevents Aggregate explosion.
- Improves readability.
- Keeps consistency boundaries intact.

---

## Violations

- Referencing Internal Entities directly.
- Sharing Internal Entities across Contexts.
- Exposing Internal Entity repositories.

---

Status

FROZEN
