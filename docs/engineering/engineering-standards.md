# Engineering Standards

## Purpose

This document defines the engineering rules that every implementation must follow.

Architecture decisions are mandatory.

Business Rules are mandatory.

No implementation may violate Domain boundaries.


---

# General Principles

- Domain Driven Design
- Clean Architecture
- SOLID
- Dependency Inversion
- Explicit Business Rules
- Event Driven Integration
- Immutable Domain Events
- Value Objects preferred over primitives
- Aggregate consistency first


---

# Implementation Rules

Every Context contains:

- Domain
- Application
- Infrastructure
- Contracts

Repositories belong to Domain.

Adapters belong to Infrastructure.

Application orchestrates use cases.

Domain contains business logic only.


---

# Testing Standards

Every Aggregate:

- Unit Tests

Every Use Case:

- Application Tests

Every Adapter:

- Integration Tests

Every Public Contract:

- Contract Tests

