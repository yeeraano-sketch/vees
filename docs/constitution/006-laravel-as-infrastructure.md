# 006 — Laravel as Infrastructure

Status

ACTIVE

---

## Intent

Laravel is an implementation framework.

Business rules never depend on Laravel.

---

## Rules

- Controllers orchestrate only.
- Eloquent belongs to Infrastructure.
- Requests belong to API.
- Service Providers configure dependencies.
- Queues, Cache, Database and HTTP remain Infrastructure concerns.

---

## Consequences

- Framework independence.
- Easier upgrades.
- Higher testability.

---

## Violations

- Domain depending on Laravel classes.
- Business rules inside Controllers.
- Eloquent Models inside Domain.

---

Status

FROZEN
