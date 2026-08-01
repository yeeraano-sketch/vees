# 002 — Modular Monolith

Status

ACTIVE

---

## Intent

The platform is implemented as a Modular Monolith.

Bounded Contexts are isolated logical modules.

---

## Rules

- Every Context owns its Domain.
- No Context accesses another Context's internals.
- Communication occurs through Contracts or Domain Events.
- SharedKernel contains only reusable primitives.
- No business logic belongs in SharedKernel.

---

## Consequences

- High cohesion.
- Low coupling.
- Future extraction into microservices remains possible.

---

## Violations

- Direct repository access across Contexts.
- Importing another Context's Aggregate.

---

Status

FROZEN
