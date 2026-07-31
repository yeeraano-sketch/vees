# Design Session 03 — Provider Context

## Responsibility

The Provider Context manages the provider lifecycle, identity, operational availability, and configuration.

## Owns

- Provider Identity
- Provider Profile
- Language
- City
- Work Mode
- Availability
- Busy / Idle Status
- Verification Status
- Provider State

## Does Not Own

- Subscription
- Session
- Matching
- Rating
- Notifications
- Payments
- Translation

## Publishes Events

- ProviderRegistered
- ProviderVerified
- ProviderActivated
- ProviderDeactivated
- ProviderWentOnline
- ProviderWentOffline
- ProviderBecameBusy
- ProviderBecameAvailable
- ProviderWorkModeChanged
- ProviderLanguageChanged
- ProviderCityChanged

## Consumes Events

- SubscriptionActivated
- SubscriptionExpired
- SessionAssigned
- SessionCompleted
- SessionCancelled

---

## Aggregate Root

### Provider

The Provider aggregate is the single consistency boundary of the Provider Context.

It is responsible for:

- Registration
- Verification
- Activation
- Deactivation
- Going online
- Going offline
- Becoming busy
- Becoming available
- Changing work mode
- Changing language
- Changing city

No other Aggregate exists inside the Provider Context.

Subscription, Rating, Matching, and Session belong to their own Bounded Contexts.

---

## Internal Model

### Provider Aggregate Data

The Provider aggregate stores only data that belongs to the Provider Context.

### Attributes

- ProviderId
- FullName
- PhoneNumber
- Language
- City
- WorkMode
- ProviderState
- AvailabilityStatus
- VerificationStatus
- RegisteredAt
- UpdatedAt

### External References

The Provider aggregate never embeds or owns data from other contexts.

It only references external concepts by their identifiers when necessary.

Examples:

- SubscriptionId (Subscription Context)
- ActiveSessionId (Session Context)

No Subscription, Session, Rating, or Matching objects exist inside the Provider aggregate.


---

## Provider Invariants

The following rules must always be true.

1. A Provider has exactly one ProviderId.

2. A Provider belongs to exactly one City at any point in time.

3. A Provider has exactly one preferred Language.

4. A Provider has exactly one WorkMode.

5. A Provider cannot be Online unless it is Active.

6. A Provider cannot become Busy while Offline.

7. A Busy Provider cannot change WorkMode.

8. A Busy Provider cannot change City.

9. A Busy Provider cannot become Available without finishing or cancelling the active session.

10. An Unverified Provider cannot become Active.

11. A Deactivated Provider cannot go Online.

12. Every state transition must be valid according to the Provider State Machine.


---

## Provider State Model

### Lifecycle States

- Registered
- Verified
- Active
- Suspended
- Deactivated

### Operational States

- Offline
- Online
- Busy

### Work Modes

- TaxiOnly
- DeliveryOnly
- TaxiAndDelivery

### Verification States

- Pending
- Verified
- Rejected

## Notes

The lifecycle state, operational state, and verification state are independent concepts.

A Provider always has exactly one state from each category.

The Provider State Machine governs only valid transitions between these states.


---

## State Machine Design

The Provider Context uses three independent state machines.

### ProviderLifecycleStateMachine

Responsible for the provider account lifecycle.

States:

- Registered
- Verified
- Active
- Suspended
- Deactivated

### ProviderOperationalStateMachine

Responsible for operational availability.

States:

- Offline
- Online
- Busy

### ProviderVerificationStateMachine

Responsible for identity verification.

States:

- Pending
- Verified
- Rejected

Each state machine owns its own transition rules.

No state machine is responsible for another one's transitions.


---

## Value Objects

The Provider Context defines the following Value Objects.

### Identity

- ProviderId

### Profile

- FullName
- PhoneNumber

### Location

- City

### Communication

- Language

### Work

- WorkMode

### Status

- ProviderLifecycleState
- ProviderOperationalState
- ProviderVerificationState

### Time

- RegisteredAt
- UpdatedAt

## Rules

- Value Objects are immutable.
- Value Objects have no identity.
- Equality is based on value.
- Every Value Object validates itself.
- Invalid Value Objects can never exist.


---

## Domain Events

The Provider aggregate may publish the following Domain Events.

### Registration

- ProviderRegistered

### Verification

- ProviderVerified
- ProviderVerificationRejected

### Lifecycle

- ProviderActivated
- ProviderSuspended
- ProviderDeactivated

### Operational

- ProviderWentOnline
- ProviderWentOffline
- ProviderBecameBusy
- ProviderBecameAvailable

### Configuration

- ProviderLanguageChanged
- ProviderCityChanged
- ProviderWorkModeChanged

## Event Rules

- Every event represents something that has already happened.
- Events are immutable.
- Events are expressed in the past tense.
- Events never contain behavior.
- Events contain only the information required by subscribers.


---

## Commands

The Provider aggregate accepts the following Commands.

### Registration

- RegisterProvider

### Verification

- VerifyProvider
- RejectProviderVerification

### Lifecycle

- ActivateProvider
- SuspendProvider
- DeactivateProvider

### Operational

- GoOnline
- GoOffline
- MarkProviderBusy
- MarkProviderAvailable

### Configuration

- ChangeProviderLanguage
- ChangeProviderCity
- ChangeProviderWorkMode

## Command Rules

- Commands express intent.
- Commands are immutable.
- Commands are named using imperative verbs.
- A Command may succeed or fail.
- A successful Command may publish one or more Domain Events.


---

## Domain Policies

The Provider Context defines the following business policies.

### Activation Policy

A Provider may be activated only if:

- Identity verification is completed.
- An active Subscription exists.

### Availability Policy

A Provider may go Online only if:

- The Provider is Active.
- The Provider is not Busy.

### Work Mode Policy

A Provider may change WorkMode only if:

- The Provider is Offline.
- The Provider is not Busy.

### City Change Policy

A Provider may change City only if:

- The Provider is Offline.
- The Provider has no active Session.

### Deactivation Policy

A Provider may be deactivated at any time by an Administrator.

## Policy Rules

Policies may depend on external contexts.

Policies are evaluated before executing Commands.

Policies never modify aggregate state directly.


---

## Public Contracts

The Provider Context exposes only the following public contracts to other Bounded Contexts.

### Commands Accepted

- RegisterProvider
- VerifyProvider
- RejectProviderVerification
- ActivateProvider
- SuspendProvider
- DeactivateProvider
- GoOnline
- GoOffline
- MarkProviderBusy
- MarkProviderAvailable
- ChangeProviderLanguage
- ChangeProviderCity
- ChangeProviderWorkMode

### Events Published

- ProviderRegistered
- ProviderVerified
- ProviderVerificationRejected
- ProviderActivated
- ProviderSuspended
- ProviderDeactivated
- ProviderWentOnline
- ProviderWentOffline
- ProviderBecameBusy
- ProviderBecameAvailable
- ProviderLanguageChanged
- ProviderCityChanged
- ProviderWorkModeChanged

### Query Contracts

The Provider Context may expose read-only queries for:

- Provider Profile
- Provider Availability
- Provider Work Mode
- Provider Language
- Provider City
- Provider Verification Status
- Provider Lifecycle Status

## Contract Rules

- Other Bounded Contexts must depend only on these contracts.
- Internal domain objects are never exposed.
- Internal repositories are never shared.
- Internal state machines are never shared.


---

## Entities

### Aggregate Root

- Provider

### Child Entities

None.

## Rationale

At the current stage of the MVP, the Provider aggregate is small enough to own all of its data directly.

No child entity has its own lifecycle or identity inside the Provider Context.

If future business requirements introduce independent lifecycles (for example, Provider Documents or Provider Vehicles), they may become child entities or even separate aggregates after a new design review.


---

## Domain Services

None.

## Rationale

At the current MVP stage, all business behavior belongs to the Provider aggregate.

No business rule currently spans multiple Provider aggregates.

If future requirements introduce business operations involving multiple Provider aggregates or complex domain calculations, a dedicated Domain Service may be introduced after architectural review.


---

## Read Models

The Provider Context exposes the following read models.

### ProviderProfileView

Contains:

- ProviderId
- FullName
- PhoneNumber
- Language
- City

### ProviderAvailabilityView

Contains:

- ProviderId
- LifecycleState
- OperationalState
- WorkMode
- IsAvailable

### ProviderSummaryView

Contains:

- ProviderId
- VerificationState
- LifecycleState
- OperationalState
- City
- Language

## Read Model Rules

- Read models are optimized for queries.
- Read models contain no business behavior.
- Read models may be rebuilt from Domain Events.
- Read models are not used to enforce business rules.


---

## Integration Rules & Event Flow

### Integration Rules

The Provider Context never accesses another Bounded Context directly.

Communication with other contexts happens only through:

- Domain Events
- Public Contracts

The Provider Context never depends on:

- Internal Aggregates
- Internal Repositories
- Internal State Machines
- Internal Value Objects

of another Bounded Context.

### Incoming Events

- SubscriptionActivated
- SubscriptionExpired
- SessionAssigned
- SessionCompleted
- SessionCancelled

### Outgoing Events

- ProviderRegistered
- ProviderVerified
- ProviderVerificationRejected
- ProviderActivated
- ProviderSuspended
- ProviderDeactivated
- ProviderWentOnline
- ProviderWentOffline
- ProviderBecameBusy
- ProviderBecameAvailable
- ProviderLanguageChanged
- ProviderCityChanged
- ProviderWorkModeChanged

### Event Flow

Subscription Context
        │
        ▼
SubscriptionActivated
        │
        ▼
Provider Context
        │
        ▼
ProviderActivated
        │
        ▼
Notification Context

Session Context
        │
        ▼
SessionAssigned
        │
        ▼
Provider Context
        │
        ▼
ProviderBecameBusy

Session Context
        │
        ▼
SessionCompleted
        │
        ▼
Provider Context
        │
        ▼
ProviderBecameAvailable


---

# Decision Log

## ADR-001

Decision:
Provider Context owns exactly one Aggregate Root (Provider).

Reason:
The Provider is the only consistency boundary required for the MVP.

---

## ADR-002

Decision:
Subscription is a separate Bounded Context.

Reason:
Subscription has its own lifecycle, policies, and business rules.

---

## ADR-003

Decision:
Rating is a separate Bounded Context.

Reason:
Rating evolves independently and affects multiple contexts.

---

## ADR-004

Decision:
The Provider Context exposes only Public Contracts and Domain Events.

Reason:
To prevent direct coupling between Bounded Contexts.

---

## ADR-005

Decision:
Provider uses three independent State Machines.

Reason:
Avoid State Explosion and keep each state machine responsible for a single concern.

---

## ADR-006

Decision:
The Provider Aggregate contains no child entities in the MVP.

Reason:
No internal object currently has an independent identity or lifecycle.

---

## ADR-007

Decision:
Business logic remains inside the Aggregate whenever possible.

Reason:
Maintain a Rich Domain Model and avoid Anemic Domain Models.

