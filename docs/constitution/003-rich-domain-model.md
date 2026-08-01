# 003 — Rich Domain Model

Status

ACTIVE

---

## Intent

Business behavior belongs inside the Domain Model.

Aggregates protect invariants.

Objects encapsulate behavior instead of exposing mutable data.

---

## Rules

- Aggregates contain business behavior.
- Entities contain behavior.
- Value Objects are immutable.
- No public setters.
- Constructors preserve invariants.
- Domain Events are raised only by Aggregate Roots.

---

## Consequences

- Strong encapsulation.
- Predictable state transitions.
- Business rules remain centralized.

---

## Violations

- Anemic models.
- Public mutable properties.
- Business logic inside Controllers or Services.

---

Status

FROZEN
