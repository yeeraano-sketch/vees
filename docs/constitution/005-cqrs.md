# 005 — CQRS

Status

ACTIVE

---

## Intent

Commands modify state.

Queries read state.

Reading and writing are separated.

---

## Rules

- Commands never return read models.
- Queries never modify state.
- Every Command has one Handler.
- Every Query has one Handler.
- Commands enforce business rules through Aggregates.

---

## Consequences

- Clear responsibilities.
- Easier testing.
- Better scalability.

---

## Violations

- Reading inside Command Handlers.
- Writing inside Query Handlers.

---

Status

FROZEN
