# Engineering Standards

## Design Order

Every Bounded Context must follow this sequence:

1. Responsibility
2. Aggregate
3. Invariants
4. Business Rules
5. State Catalog (if applicable)
6. Transition Table
7. Commands
8. Domain Events
9. Policies
10. Public Contracts
11. Review
12. Freeze

---

## Aggregate Rules

- One Aggregate Root per Context.
- Aggregates protect invariants.
- Aggregates never communicate directly.

---

## Domain Events

- Represent completed business facts.
- One publisher per event.
- Events are immutable.

---

## Commands

- Express business intent.
- One owner.
- One actor.
- Preconditions required.

---

## Policies

Policies:

- Observe Events.
- Evaluate business conditions.
- Issue Commands.

Policies never modify Aggregate state directly.

---

## Reviews

Every Context must pass:

- Responsibility Review
- Aggregate Review
- Business Rule Review
- Transition Review
- Architecture Review

before Freeze.

