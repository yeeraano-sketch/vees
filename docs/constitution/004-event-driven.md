# 004 — Event Driven Architecture

Status

ACTIVE

---

## Intent

Bounded Contexts communicate through Domain Events.

Events describe facts that already happened.

---

## Rules

- Events are immutable.
- Events describe the past.
- Events never contain business logic.
- Publishers do not know subscribers.
- Subscribers must be idempotent.
- Domain Events are published after successful state changes.

---

## Consequences

- Loose coupling.
- Independent Context evolution.
- Easy integration.

---

## Violations

- Calling another Context directly.
- Modifying another Aggregate.
- Executing business logic inside Event objects.

---

Status

FROZEN
