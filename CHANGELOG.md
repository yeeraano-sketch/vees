# Changelog

All notable changes to this project will be documented in this file.

## [1.0.0] - 2026-08-02

### Added
- Modular architecture.
- Shared Kernel.
- CQRS infrastructure.
- Transactional Command Bus.
- Event Dispatcher.
- Aggregate Collector.
- Domain Service Provider.
- Laravel integration layer.
- Module Registrars.
- Unit of Work abstraction.

### Changed
- Separated application core from Laravel runtime.
- Moved dependency registration into module registrars.
- Simplified framework bootstrap.

### Removed
- Legacy contracts.
- Legacy Laravel EventBus implementation.
- DependencyRegistry.
- ModuleRegistrar.
