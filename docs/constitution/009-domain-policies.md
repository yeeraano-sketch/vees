# 009 — Domain Policies

Status

ACTIVE

---

## Intent

Business decisions involving multiple rules or external context belong to Domain Policies.

Policies coordinate decision making without owning state.

---

## Rules

- Policies do not persist data.
- Policies do not own identity.
- Policies encapsulate business decisions.
- Policies may use Specifications.
- Policies may collaborate with Aggregates but never replace them.

---

## Consequences

- Smaller Aggregates.
- Centralized business decisions.
- Easier evolution of business rules.

---

## Violations

- Large decision trees inside Aggregates.
- Business policies inside Controllers.
- Cross-context business rules inside Infrastructure.

---

Status

FROZEN
