# ADR 0001: Unified Vees Repository

## Status
Accepted (2026-08-03)

## Context
The Vees platform initially had multiple repositories (`vees`, `vees-core`, `vees-main`) causing fragmentation.
We need a single source of truth for all code, governance, and documentation.

## Decision
- `vees` becomes the only active repository.
- `vees-core` is integrated as the foundation under `src/`.
- `vees-main` serves only as a historical reference; its code is extracted and repaired during migration.
- All future development happens exclusively in `vees`.

## Consequences
- Single CI/CD pipeline, issue tracker, and governance files.
- Clear ownership and reduced maintenance overhead.
- Consistent namespace and architecture across all bounded contexts.
