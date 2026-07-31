# Subscription Context

## Responsibility

The Subscription Context is responsible only for managing Provider subscriptions.

It owns the complete subscription lifecycle, including:

- Subscription creation
- Manual renewal
- Activation
- Expiration
- Grace period
- Subscription status
- Eligibility for receiving new sessions

## It Owns

- Subscription
- Subscription lifecycle
- Subscription validity
- Grace period
- Expiration date
- Renewal history

## It Does Not Own

- Provider profile
- Provider availability
- Sessions
- Matching
- Ratings
- Notifications

## Published Events

(To be defined.)

## Consumed Events

(To be defined.)


---

## Aggregate

### Aggregate Root

Subscription

## Aggregate Responsibility

The Subscription aggregate is the single consistency boundary for subscription management.

It is responsible for:

- Creating a subscription
- Activating a subscription
- Renewing a subscription
- Expiring a subscription
- Managing the grace period
- Determining whether the subscription is eligible to receive new sessions

The aggregate never manages:

- Provider profile
- Session lifecycle
- Payment processing
- Notifications


---

## Business Invariants

The following business rules must always hold true.

### Subscription Ownership

A Subscription always belongs to exactly one Provider.

A Provider may have many subscriptions over time, but only one active subscription at any given moment.

### Active Subscription

Only one Subscription may be Active for the same Provider.

### Expiration

Every Subscription has a fixed start date and expiration date.

### Grace Period

A Grace Period begins immediately after the Subscription expires.

During the Grace Period:

- No new Sessions may be assigned.
- Existing active Sessions may continue until completion.

### Renewal

Renewing a Subscription creates a new subscription period.

Renewal never modifies historical subscription periods.

### Eligibility

Only an Active Subscription allows a Provider to receive new Sessions.

## Invariant Rules

Business Invariants are enforced inside the Subscription Aggregate.

No Command may violate these rules.


---

## State Model

The Subscription aggregate has the following lifecycle states.

### Draft

The subscription has been created but is not yet active.

### Active

The subscription is valid.

The Provider may receive new Sessions.

### GracePeriod

The subscription has expired.

The Provider may finish existing Sessions but cannot receive new ones.

### Expired

The grace period has ended.

The Provider is no longer eligible to receive any Sessions.

### Cancelled

The subscription has been permanently cancelled before expiration.

## State Transitions

Draft
    │
    ▼
Active
    │
    ▼
GracePeriod
    │
    ▼
Expired

Draft ─────────────► Cancelled

Active ────────────► Cancelled

## Transition Rules

A Subscription never returns to a previous state.

A cancelled Subscription cannot be reactivated.

A renewed Subscription creates a new Subscription Aggregate instance rather than changing the lifecycle of an expired Subscription.


---

## State Machine

### Draft

Allowed Commands

- ActivateSubscription
- CancelSubscription

Forbidden Commands

- RenewSubscription
- ExpireSubscription
- EndGracePeriod

---

### Active

Allowed Commands

- ExpireSubscription
- CancelSubscription

Forbidden Commands

- ActivateSubscription
- EndGracePeriod

---

### GracePeriod

Allowed Commands

- EndGracePeriod

Forbidden Commands

- ActivateSubscription
- CancelSubscription
- ExpireSubscription

---

### Expired

Allowed Commands

None.

Forbidden Commands

- ActivateSubscription
- RenewSubscription
- CancelSubscription
- ExpireSubscription
- EndGracePeriod

---

### Cancelled

Allowed Commands

None.

Forbidden Commands

-
cat >> docs/design/04-subscription-context.md <<'EOF'

---

## State Machine

### Draft

Allowed Commands

- ActivateSubscription
- CancelSubscription

Forbidden Commands

- RenewSubscription
- ExpireSubscription
- EndGracePeriod

---

### Active

Allowed Commands

- ExpireSubscription
- CancelSubscription

Forbidden Commands

- ActivateSubscription
- EndGracePeriod

---

### GracePeriod

Allowed Commands

- EndGracePeriod

Forbidden Commands

- ActivateSubscription
- CancelSubscription
- ExpireSubscription

---

### Expired

Allowed Commands

None.

Forbidden Commands

- ActivateSubscription
- RenewSubscription
- CancelSubscription
- ExpireSubscription
- EndGracePeriod

---

### Cancelled

Allowed Commands

None.

Forbidden Commands

- ActivateSubscription
- RenewSubscription
- CancelSubscription
- ExpireSubscription
- EndGracePeriod

## State Machine Rules

Only commands explicitly allowed in the current state may execute.

Invalid commands must be rejected.

A successful command may produce one or more Domain Events.


---

## Value Objects

### SubscriptionStatus

Represents the lifecycle status of a Subscription.

Possible values:

- Draft
- Active
- GracePeriod
- Expired
- Cancelled

### SubscriptionPeriod

Represents the validity period of a Subscription.

Contains:

- StartDate
- ExpirationDate

### GracePeriod

Represents the grace period following subscription expiration.

Contains:

- StartDate
- EndDate

### SubscriptionPlan

Represents the selected subscription plan.

Possible values:

- Taxi
- Delivery
- TaxiAndDelivery

### SubscriptionPrice

Represents the monthly subscription fee.

Rules:

- Must be greater than zero.
- Currency is Saudi Riyal (SAR).

## Value Object Rules

- Immutable.
- Self-validating.
- No identity.
- Equality is based on value.


---

## Domain Events

The Subscription Context publishes the following Domain Events.

### SubscriptionCreated

A new Subscription has been created.

### SubscriptionActivated

The Subscription has become active.

### SubscriptionExpired

The Subscription has reached its expiration date.

### SubscriptionGracePeriodStarted

The grace period has started.

### SubscriptionGracePeriodEnded

The grace period has ended.

### SubscriptionCancelled

The Subscription has been cancelled.

## Event Rules

- Events are immutable.
- Events describe facts that already happened.
- Events are expressed in the past tense.
- Events contain only the data required by other Bounded Contexts.
- Events never expose internal implementation details.


---

## Commands

The Subscription Context accepts the following Commands.

### CreateSubscription

Creates a new Subscription in the Draft state.

### ActivateSubscription

Activates a Draft Subscription.

### ExpireSubscription

Moves an Active Subscription to GracePeriod.

### EndGracePeriod

Moves a Subscription from GracePeriod to Expired.

### CancelSubscription

Cancels a Draft or Active Subscription.

## Command Rules

- Commands express business intent.
- Commands are imperative.
- Commands may be accepted or rejected.
- Successful Commands may produce one or more Domain Events.
- Failed Commands never produce Domain Events.


---

## Command Sources

Each Command has a well-defined source.

| Command | Source |
|---------|--------|
| CreateSubscription | Administrator |
| ActivateSubscription | Administrator |
| ExpireSubscription | Scheduler |
| EndGracePeriod | Scheduler |
| CancelSubscription | Administrator |

## Rules

Every Command must have exactly one business source.

A Command is never executed automatically without an identified source.

Time-based Commands are triggered only by the Scheduler.


---

## Domain Policies

### Subscription Activation Policy

A Subscription may be activated only after the subscription payment has been confirmed.

### Session Eligibility Policy

Only Providers with an Active Subscription may receive new Sessions.

Providers in GracePeriod may complete existing Sessions but must not receive new ones.

### Grace Period Policy

The Grace Period always starts immediately after subscription expiration.

The Grace Period lasts exactly 48 hours.

### Renewal Policy

A renewed subscription always creates a new Subscription.

Historical subscription records are never modified.

### Cancellation Policy

A cancelled Subscription immediately loses eligibility to receive new Sessions.

## Policy Rules

Policies represent business rules.

Policies may depend on business facts from outside the Aggregate.

Policies never change aggregate state directly.


---

## Public Contracts

The Subscription Context exposes only the following public contracts.

### Commands Accepted

- CreateSubscription
- ActivateSubscription
- ExpireSubscription
- EndGracePeriod
- CancelSubscription

### Events Published

- SubscriptionCreated
- SubscriptionActivated
- SubscriptionExpired
- SubscriptionGracePeriodStarted
- SubscriptionGracePeriodEnded
- SubscriptionCancelled

### Query Contracts

The Subscription Context may expose read-only queries for:

- Current Subscription Status
- Current Subscription Plan
- Subscription Validity Period
- Grace Period Status
- Provider Eligibility

## Contract Rules

- Other Bounded Contexts communicate only through these contracts.
- Internal Aggregates are never exposed.
- Internal Repositories are never exposed.
- Internal State Machines are never exposed.
- Internal Value Objects are never exposed.


---

## Entities

### Aggregate Root

- Subscription

### Child Entities

None.

## Rationale

At the current MVP stage, the Subscription aggregate owns all of its business data directly.

Subscription periods, plans, prices, and grace periods are modeled as Value Objects.

No child object currently has an independent identity or lifecycle.

If future business requirements introduce concepts such as invoices, payment transactions, or payment attempts managed inside this context, the model will be reviewed before introducing additional entities.


---

## Domain Services

None.

## Rationale

At the current MVP stage, all subscription business behavior belongs to the Subscription aggregate.

No business operation currently spans multiple Subscription aggregates.

If future requirements introduce cross-subscription calculations, billing coordination, or complex subscription policies involving multiple aggregates, a dedicated Domain Service may be introduced after architectural review.


---

## Read Models

The Subscription Context exposes the following read models.

### SubscriptionSummaryView

Contains:

- SubscriptionId
- ProviderId
- SubscriptionStatus
- SubscriptionPlan

### SubscriptionValidityView

Contains:

- StartDate
- ExpirationDate
- GracePeriodStart
- GracePeriodEnd
- IsEligibleForNewSessions

### SubscriptionHistoryView

Contains:

- ProviderId
- SubscriptionId
- SubscriptionPlan
- SubscriptionStatus
- ActivatedAt
- ExpiredAt
- CancelledAt

## Read Model Rules

- Read Models are optimized for queries.
- Read Models contain no business behavior.
- Read Models may be rebuilt from Domain Events.
- Read Models are never used to enforce business rules.


---

## Integration Rules & Event Flow

### Integration Rules

The Subscription Context never accesses another Bounded Context directly.

Communication with other contexts happens only through:

- Domain Events
- Public Contracts

The Subscription Context never depends on:

- Internal Aggregates
- Internal Repositories
- Internal State Machines
- Internal Value Objects

of another Bounded Context.

### Incoming Events

- ProviderRegistered
- ProviderActivated

### Outgoing Events

- SubscriptionCreated
- SubscriptionActivated
- SubscriptionExpired
- SubscriptionGracePeriodStarted
- SubscriptionGracePeriodEnded
- SubscriptionCancelled

### Event Flow

Provider Context
        │
        ▼
ProviderRegistered
        │
        ▼
Subscription Context
        │
        ▼
SubscriptionCreated

Administrator
        │
        ▼
ActivateSubscription
        │
        ▼
SubscriptionActivated
        │
        ▼
Provider Context

Scheduler
        │
        ▼
ExpireSubscription
        │
        ▼
SubscriptionExpired
        │
        ▼
SubscriptionGracePeriodStarted
        │
        ▼
Provider Context

Scheduler
        │
        ▼
EndGracePeriod
        │
        ▼
SubscriptionGracePeriodEnded
        │
        ▼
Provider Context


---

# Decision Log

## ADR-001

Decision:
Subscription is the only Aggregate Root.

Reason:
It is the single consistency boundary for subscription management.

---

## ADR-002

Decision:
Subscription and Payment are separate concepts.

Reason:
The MVP supports manual payments only.
Payment processing is outside the Subscription Context.

---

## ADR-003

Decision:
Every renewal creates a new Subscription.

Reason:
Historical subscription periods must never be modified.

---

## ADR-004

Decision:
The Subscription Context exposes only Public Contracts and Domain Events.

Reason:
Prevent direct coupling between Bounded Contexts.

---

## ADR-005

Decision:
Grace Period is part of the Subscription lifecycle.

Reason:
Business rules require Providers to finish existing Sessions while preventing new assignments.

---

## ADR-006

Decision:
The Subscription Aggregate contains no child entities in the MVP.

Reason:
No internal object currently has an independent identity or lifecycle.

---

## ADR-007

Decision:
Business logic remains inside the Aggregate whenever possible.

Reason:
Maintain a Rich Domain Model and avoid Anemic Domain Models.

