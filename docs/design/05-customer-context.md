# Customer Context

## Responsibility

The Customer Context is responsible only for managing Customer identity, profile, preferences, and eligibility to request services.

It owns the complete customer lifecycle, including:

- Customer registration
- Customer profile
- Preferred language
- Contact information
- Customer status
- Customer verification
- Customer preferences

## It Owns

- Customer
- Customer profile
- Preferred language
- Contact information
- Verification status
- Customer preferences

## It Does Not Own

- Sessions
- Matching
- Providers
- Ratings
- Notifications
- Subscriptions

## Published Events

(To be defined.)

## Consumed Events

(To be defined.)


---

## Aggregate

### Aggregate Root

Customer

## Aggregate Responsibility

The Customer aggregate is the single consistency boundary for customer management.

It is responsible for:

- Registering a Customer
- Maintaining the customer profile
- Managing verification status
- Managing preferred language
- Managing contact information
- Managing customer preferences

The aggregate never manages:

- Sessions
- Providers
- Ratings
- Matching
- Notifications
- Subscription lifecycle


---

## Business Invariants

The following business rules must always hold true.

### Customer Identity

A Customer has exactly one identity within the platform.

### Contact Information

A Customer must always have valid contact information.

### Preferred Language

A Customer always has exactly one preferred language.

### Verification

Only verified Customers may request new Sessions.

### Status

A suspended Customer may not request new Sessions.

Existing Sessions may continue according to Session Context rules.

### Preferences

Customer preferences affect future Sessions only.

Changing preferences never modifies active Sessions.

## Invariant Rules

Business Invariants are enforced inside the Customer Aggregate.

No Command may violate these rules.


---

## State Model

The Customer aggregate has the following lifecycle states.

### Registered

The Customer has completed registration.

### Verified

The Customer identity has been verified.

The Customer may request new Sessions if not suspended.

### Suspended

The Customer is temporarily blocked from requesting new Sessions.

### Archived

The Customer account is permanently archived.

No further business operations are allowed.

## State Transitions

Registered
    │
    ▼
Verified
    │
    ├────────────► Suspended
    │                 │
    │                 ▼
    └────────────► Verified

Verified ─────────► Archived

Suspended ────────► Archived

## Transition Rules

A Customer must be registered before verification.

A suspended Customer may be reinstated to Verified.

An archived Customer cannot return to any previous state.


---

## State Machine Design

The Customer Context uses three independent State Machines.

### Lifecycle State Machine

States:

- Registered
- Archived

Purpose:

Represents the lifecycle of the Customer.

---

### Verification State Machine

States:

- PendingVerification
- Verified

Purpose:

Represents the verification status of the Customer.

---

### Operational State Machine

States:

- Available
- Suspended

Purpose:

Represents whether the Customer is allowed to request new Sessions.

---

## Eligibility

Customer Eligibility is a derived business fact.

A Customer is eligible to request new Sessions only when:

- Lifecycle = Registered
- Verification = Verified
- Operational = Available

Eligibility is not stored as a separate state.


---

## Value Objects

The Customer Context defines the following Value Objects.

### CustomerId

Uniquely identifies a Customer.

### FullName

Represents the Customer's full legal name.

### PhoneNumber

Represents the Customer's contact phone number.

### PreferredLanguage

Represents the Customer's selected language.

Supported languages:

- Arabic
- English
- Urdu
- Hindi
- Bengali
- Tagalog

### CustomerPreferences

Represents customer-specific preferences that influence future Sessions.

Examples:

- Preferred service type
- Notification preferences

## Value Object Rules

Value Objects are immutable.

Value Objects have no identity.

Value Objects validate themselves during construction.

Two Value Objects are equal if all their attributes are equal.


---

## Domain Events

The Customer Context publishes the following Domain Events.

### CustomerRegistered

A new Customer has been successfully registered.

### CustomerVerified

The Customer identity has been verified.

### CustomerSuspended

The Customer has been suspended.

### CustomerReinstated

The Customer suspension has been lifted.

### CustomerArchived

The Customer has been permanently archived.

### CustomerProfileUpdated

The Customer profile has been updated.

### CustomerPreferencesChanged

The Customer preferences have changed.

## Event Rules

Events are immutable.

Events describe facts that already happened.

Events are expressed in the past tense.

Events expose only the data required by other Bounded Contexts.

Internal implementation details are never exposed.


---

## Commands

The Customer Context accepts the following Commands.

### RegisterCustomer

Registers a new Customer.

### VerifyCustomer

Marks a Customer as verified.

### SuspendCustomer

Suspends a Customer.

### ReinstateCustomer

Removes the suspension from a Customer.

### ArchiveCustomer

Archives a Customer permanently.

### UpdateCustomerProfile

Updates the Customer profile information.

### ChangeCustomerPreferences

Updates Customer preferences.

## Command Rules

Commands express business intent.

Commands are imperative.

Commands may be accepted or rejected.

Successful Commands may produce one or more Domain Events.

Failed Commands never produce Domain Events.


---

## Command Sources

Each Command has exactly one business source.

| Command | Source |
|----------|--------|
| RegisterCustomer | Customer |
| VerifyCustomer | Administrator |
| SuspendCustomer | Administrator |
| ReinstateCustomer | Administrator |
| ArchiveCustomer | Administrator |
| UpdateCustomerProfile | Customer |
| ChangeCustomerPreferences | Customer |

## Rules

Every Command has a single business source.

Commands are never executed without an identified business actor.

System-initiated actions must originate from an identified system component.


---

## Domain Policies

### Customer Eligibility Policy

A Customer may request new Sessions only when eligible.

Eligibility is derived from:

- Lifecycle = Registered
- Verification = Verified
- Operational = Available

### Suspension Policy

A suspended Customer may not request new Sessions.

Active Sessions are governed by the Session Context.

### Profile Update Policy

Profile updates affect only future business operations.

Active Sessions are never modified by profile changes.

### Preference Change Policy

Preference changes apply only to future Sessions.

Existing Sessions continue unchanged.

## Policy Rules

Policies represent business rules.

Policies may depend on facts from other Bounded Contexts.

Policies never modify Aggregate state directly.


---

## Public Contracts

The Customer Context exposes only the following public contracts.

### Commands Accepted

- RegisterCustomer
- VerifyCustomer
- SuspendCustomer
- ReinstateCustomer
- ArchiveCustomer
- UpdateCustomerProfile
- ChangeCustomerPreferences

### Events Published

- CustomerRegistered
- CustomerVerified
- CustomerSuspended
- CustomerReinstated
- CustomerArchived
- CustomerProfileUpdated
- CustomerPreferencesChanged

### Query Contracts

The Customer Context may expose read-only queries for:

- Customer Profile
- Customer Verification Status
- Customer Operational Status
- Customer Eligibility
- Customer Preferred Language
- Customer Preferences

## Contract Rules

Other Bounded Contexts communicate only through these contracts.

Internal Aggregates are never exposed.

Internal Repositories are never exposed.

Internal State Machines are never exposed.

Internal Value Objects are never exposed.


---

## Entities

### Aggregate Root

- Customer

### Child Entities

None.

## Rationale

At the current MVP stage, the Customer aggregate owns all of its business data directly.

Customer profile, preferences, and contact information are modeled as Value Objects.

No child object currently has an independent identity or lifecycle.

If future business requirements introduce concepts such as multiple addresses, emergency contacts, or identity documents with independent lifecycles, the model will be reviewed before introducing additional entities.


---

## Domain Services

None.

## Rationale

At the current MVP stage, all customer business behavior belongs to the Customer aggregate.

No business operation currently spans multiple Customer aggregates.

If future business requirements introduce cross-customer rules, fraud detection, customer segmentation, or complex eligibility calculations involving multiple aggregates, a dedicated Domain Service may be introduced after architectural review.


---

## Read Models

The Customer Context exposes the following read models.

### CustomerProfileView

Contains:

- CustomerId
- FullName
- PhoneNumber
- PreferredLanguage

### CustomerStatusView

Contains:

- LifecycleState
- VerificationState
- OperationalState
- Eligibility

### CustomerPreferencesView

Contains:

- PreferredLanguage
- CustomerPreferences

## Read Model Rules

Read Models are optimized for queries.

Read Models contain no business behavior.

Read Models may be rebuilt from Domain Events.

Read Models are never used to enforce business rules.


---

## Integration Rules & Event Flow

### Integration Rules

The Customer Context never accesses another Bounded Context directly.

Communication with other contexts happens only through:

- Domain Events
- Public Contracts

The Customer Context never depends on:

- Internal Aggregates
- Internal Repositories
- Internal State Machines
- Internal Value Objects

of another Bounded Context.

### Incoming Events

None.

### Outgoing Events

- CustomerRegistered
- CustomerVerified
- CustomerSuspended
- CustomerReinstated
- CustomerArchived
- CustomerProfileUpdated
- CustomerPreferencesChanged

### Event Flow

Customer
        │
        ▼
RegisterCustomer
        │
        ▼
CustomerRegistered

Administrator
        │
        ▼
VerifyCustomer
        │
        ▼
CustomerVerified

Administrator
        │
        ▼
SuspendCustomer
        │
        ▼
CustomerSuspended

Administrator
        │
        ▼
ReinstateCustomer
        │
        ▼
CustomerReinstated

Customer
        │
        ▼
UpdateCustomerProfile
        │
        ▼
CustomerProfileUpdated

Customer
        │
        ▼
ChangeCustomerPreferences
        │
        ▼
CustomerPreferencesChanged


---

# Decision Log

## ADR-001

Decision:
Customer is the only Aggregate Root.

Reason:
It is the single consistency boundary for customer management.

---

## ADR-002

Decision:
Customer Eligibility is a derived business fact.

Reason:
Eligibility is computed from Lifecycle, Verification, and Operational states rather than stored independently.

---

## ADR-003

Decision:
Customer Context is the source of truth for Customer data.

Reason:
Other Bounded Contexts must consume Customer information only through Public Contracts or Domain Events.

---

## ADR-004

Decision:
Customer profile and preferences are modeled as Value Objects.

Reason:
They have no independent identity or lifecycle.

---

## ADR-005

Decision:
The Customer Context exposes only Public Contracts and Domain Events.

Reason:
Prevent direct coupling between Bounded Contexts.

---

## ADR-006

Decision:
The Customer Aggregate contains no child entities in the MVP.

Reason:
No internal object currently requires an independent identity or lifecycle.

---

## ADR-007

Decision:
Business logic remains inside the Aggregate whenever possible.

Reason:
Maintain a Rich Domain Model and avoid Anemic Domain Models.


---

# Status

## Review Status

Reviewed.

## Freeze Status

FROZEN v1.0

## Notes

The Customer Context is considered architecturally complete for the MVP.

Future modifications require a documented Architecture Decision Record (ADR) and an Architecture Review before implementation.

