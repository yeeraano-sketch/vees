# 001 — Domain First

Status

ACTIVE

---

## Intent

Business rules are the primary asset of the platform.

The framework exists to serve the Domain, never the opposite.

---

## Rules

- Domain code must not depend on Laravel.
- Domain must not know HTTP.
- Domain must not know Eloquent.
- Domain must not know Queue.
- Domain must not know Cache.
- Domain must not know Database.
- Domain contains all business rules.
- Infrastructure implements Domain contracts.

---

## Consequences

- Business logic is framework independent.
- Domain can be tested without Laravel.
- Infrastructure can be replaced without changing business rules.

---

## Violations

- Using Request inside Domain.
- Using Model inside Aggregate.
- Using DB facade inside Domain.

---

Status

FROZEN
