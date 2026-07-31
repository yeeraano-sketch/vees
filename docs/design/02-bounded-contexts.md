# Design Session 02 — Bounded Contexts

## Principles

- Each Bounded Context owns its domain model.
- No direct dependency between domain models.
- Communication between contexts is event-driven or through explicit contracts.
- Shared Kernel contains only reusable technical and domain primitives.
- No business logic is placed inside Shared Kernel.

## Approved Bounded Contexts

| Context | Responsibility |
|---------|----------------|
| Shared Kernel | Shared primitives and infrastructure only |
| Customer | Customer management |
| Provider | Provider management |
| Subscription | Subscription lifecycle |
| Session | Service session lifecycle |
| Matching | Provider matching |
| Rating | Mutual ratings |
| Notification | Notifications and translation |
| Administration | Administration and reporting |

## Architectural Rule

A Bounded Context may never directly modify another Bounded Context's state.
