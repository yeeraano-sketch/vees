# ADR 0010: TransactionMiddleware Left Empty

## Status
Accepted (2026-08-03)

## Context
We have four middlewares in the pipeline: `LoggingMiddleware`, `ValidationMiddleware`, `EventDispatchMiddleware`, and `TransactionMiddleware`. 
The `TransactionalCommandBus` already handles transaction begin/commit/rollback around the entire command execution, including event dispatch after commit.

## Decision
`TransactionMiddleware` will remain a no-op passthrough. 
The transaction boundary is managed by `TransactionalCommandBus` at a higher level, making a nested transaction middleware redundant and potentially conflicting.

## Consequences
- Clear separation of concerns: `TransactionalCommandBus` owns the transaction.
- Other middlewares remain focused on cross-cutting concerns (logging, validation, event dispatch).
- No risk of nested transaction conflicts.
