# 008 — Specification Pattern

Status

ACTIVE

---

## Intent

Business rules that are reusable and composable shall be implemented as Specifications.

Specifications express business predicates without modifying state.

---

## Rules

- Specifications never change state.
- Specifications answer only business questions.
- Specifications are reusable across Application Services and Policies.
- Aggregates may use Specifications to protect invariants.

---

## Consequences

- Eliminates duplicated business rules.
- Improves readability.
- Simplifies testing.

---

## Violations

- Business predicates duplicated in multiple places.
- Specifications with side effects.

---

Status

FROZEN
