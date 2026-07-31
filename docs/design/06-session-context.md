# Session Context

## Purpose

The Session Context owns the complete lifecycle of a service session.

A Session begins when a Customer requests a service and ends when the service is either completed or permanently cancelled.

The Session Context is the single source of truth for all service sessions.

---

## Responsibility

The Session Context is responsible for:

- Creating Sessions.
- Managing the Session lifecycle.
- Tracking Session state transitions.
- Accepting Provider responses.
- Starting service execution.
- Completing Sessions.
- Cancelling Sessions.
- Publishing Session Domain Events.

The Session Context is not responsible for:

- Customer management.
- Provider management.
- Subscription lifecycle.
- Provider matching algorithms.
- Rating calculations.
- Notification delivery.
- Administrative reporting.


---

## Aggregate

### Aggregate Root

Session

The Session aggregate is the single consistency boundary for every service session.

A Session exists independently of the service type.

Service-specific behavior is expressed through policies and Value Objects, not separate Aggregates.

---

## Invariants

The Session aggregate enforces the following invariants.

- A Session always has exactly one Customer.
- A Session belongs to exactly one City.
- A Session has exactly one Service Type.
- A Session may have zero or one Provider.
- A Provider may be assigned only once.
- A completed Session cannot be modified.
- A cancelled Session cannot be restarted.
- A Session can reach exactly one terminal state.
- Every state transition must be valid.
- Every Domain Event must originate from a valid state transition.


---

# Mini Event Storming

## Objective

Identify the complete business flow of a Session before designing its State Machine.

The flow is expressed entirely in terms of business facts (Domain Events).

Technical implementation details are intentionally excluded.

---

## Happy Path

CustomerRequestedService

↓

SessionCreated

↓

MatchingRequested

↓

ProviderMatched

↓

ProviderOfferSent

↓

ProviderAcceptedOffer

↓

ProviderAssigned

↓

ProviderArrived

↓

ServiceStarted

↓

ServiceCompleted

↓

SessionCompleted


---

## Cancellation Paths

### Customer Cancels Before Provider Assignment

CustomerCancelledSession

↓

SessionCancelled

---

### Customer Cancels After Provider Assignment

CustomerRequestedCancellation

↓

CancellationApproved

↓

SessionCancelled

---

### Provider Cancels Before Service Start

ProviderCancelledSession

↓

ProviderUnassigned

↓

MatchingRequested

---

### Provider Cancels After Service Start

ProviderRequestedCancellation

↓

CancellationRejectedOrApproved

↓

SessionCompleted
or
SessionCancelled

---

## Failure & Timeout Paths

### No Provider Found

MatchingRequested

↓

MatchingFailed

↓

SessionCancelled

---

### Provider Does Not Respond

ProviderOfferSent

↓

OfferExpired

↓

MatchingRequested

---

### Provider Rejects Offer

ProviderRejectedOffer

↓

MatchingRequested


---

# Session State Transition Table

## Objective

Define every valid state transition of the Session Aggregate.

Each transition specifies:

- Current State
- Command
- Preconditions
- Domain Event
- Next State

This table is the authoritative source for the Session State Machine.

| Current State | Command | Preconditions | Domain Event | Next State |
|-------------------------------|-------------------------|----------------------------------------|-------------------------|-------------------------------|
| Created | RequestMatching | Session is valid | MatchingRequested | WaitingForMatch |
| WaitingForMatch | AssignProvider | Provider matched | ProviderAssigned | WaitingForProviderAcceptance |
| WaitingForProviderAcceptance | AcceptOffer | Offer still valid | ProviderAcceptedOffer | ProviderAssigned |
| WaitingForProviderAcceptance | RejectOffer | Offer still valid | ProviderRejectedOffer | WaitingForRetry |
| ProviderAssigned | ProviderArrived | Provider assigned | ProviderArrived | ProviderArriving |
| ProviderArriving | StartService | Customer present | ServiceStarted | InProgress |
| InProgress | CompleteService | Service finished | SessionCompleted | Completed |
| Any Non-Terminal State | CancelSession | Cancellation allowed | SessionCancelled | Cancelled |


---

# Session Transition Table Authority

The Session Transition Table is the authoritative specification for the Session Aggregate behavior.

Any change to:

- Session States
- Commands
- Domain Events
- State Transitions
- Preconditions

must be introduced in the Transition Table before modifying any implementation or supporting documentation.

The Transition Table is considered the Single Source of Truth (SSOT) for Session behavior.

---

# Command Classification

Commands are classified into two categories.

## External Commands

External Commands originate from actors outside the Session Context.

Examples:

- CreateSession
- CancelSession
- AcceptOffer
- RejectOffer
- ArriveAtPickup
- StartService
- CompleteService

## Internal Commands

Internal Commands originate from Session Policies or consumed Domain Events.

Examples:

- RequestMatching
- RetryMatching
- AssignProvider
- ExpireProviderOffer
- CloseExpiredSession

---

# Transition Table Columns

Every transition must define:

- Current State
- Actor
- Command
- Preconditions
- Produced Domain Event
- Next State


---

# Session State Catalog

## Objective

Define every valid state of the Session Aggregate before defining transitions.

States represent the internal lifecycle of a Session.

States are not Domain Events.

States are mutually exclusive.

A Session is always in exactly one state.

## States

### Created

The Session has been created but no matching has started.

---

### WaitingForMatch

The Session is waiting for the Matching Context to find a Provider.

---

### WaitingForProviderAcceptance

A Provider has been selected and an offer is pending.

---

### ProviderAssigned

The Provider accepted the offer and is assigned to the Session.

---

### ProviderArriving

The assigned Provider is travelling to the Customer.

---

### InProgress

The service has started.

---

### WaitingForRetry

The previous matching attempt failed.
The Session is eligible for another matching attempt.

---

### Completed

Terminal State.

The Session finished successfully.

---

### Cancelled

Terminal State.

The Session was permanently cancelled.


---

# Session Business Rules

Business Rules are defined before completing the Transition Table.

Each rule becomes one or more Transition Table entries.

---

## Phase 1 — Session Creation Rules

### BR-001

A Session can only be created by a registered Customer.

---

### BR-002

A Session must specify exactly one Service Type.

---

### BR-003

A Session must belong to exactly one City.

---

### BR-004

A newly created Session starts in the Created state.

---

### BR-005

A Session may not exist without a Customer.

---

### BR-006

A Session Identifier is immutable.


---

# Business Rule Classification

Business Rules are grouped by lifecycle phase.

| Prefix | Category |
|---------|----------|
| BR-1xx | Session Creation |
| BR-2xx | Matching |
| BR-3xx | Provider Acceptance |
| BR-4xx | Service Execution |
| BR-5xx | Cancellation |
| BR-6xx | Completion |
| BR-7xx | Retry & Timeout |
| BR-8xx | Exceptional Cases |

Every Business Rule shall belong to exactly one category.


---

# BR-1xx — Session Creation

## BR-101

Only a registered Customer may create a Session.

---

## BR-102

A Session must contain exactly one Service Type.

---

## BR-103

A Session must belong to exactly one City.

---

## BR-104

A newly created Session always starts in the Created state.

---

## BR-105

A Session cannot exist without a Customer.

---

## BR-106

SessionId is immutable for the lifetime of the Session.


---

# Business Rule Lifecycle

Every Business Rule progresses through the following lifecycle.

| Status | Meaning |
|---------|---------|
| Draft | Rule identified but not reviewed |
| Approved | Rule approved during architecture review |
| Implemented | Rule implemented in the domain model |
| Tested | Rule covered by automated tests |

Each Business Rule should eventually reference:

- Transition(s)
- Aggregate Method(s)
- Domain Event(s)
- Test Case(s)


---

# BR-2xx — Matching Rules

## BR-201

Matching may only be requested when the Session is in the Created state.

---

## BR-202

A Session may have only one active matching process at a time.

---

## BR-203

Only eligible Providers may participate in matching.

---

## BR-204

A matched Provider does not become assigned until the offer is accepted.

---

## BR-205

If matching fails, the Session enters WaitingForRetry.

---

## BR-206

Retry policies are outside the Session Aggregate.


---

# Business Rule to Transition Mapping

## BR-101

Transition:
CreateSession

---

## BR-102

Transition:
CreateSession

---

## BR-103

Transition:
CreateSession

---

## BR-104

Transition:
CreateSession

Resulting State:
Created

---

## BR-201

Transition:
RequestMatching

Current State:
Created

Next State:
WaitingForMatch

---

## BR-202

Transition:
RequestMatching

Constraint:
Only one active matching process is permitted.

---

## BR-203

Transition:
AssignProvider

Precondition:
Provider must be eligible.

---

## BR-204

Transition:
AcceptOffer

Current State:
WaitingForProviderAcceptance

Next State:
ProviderAssigned

---

## BR-205

Transition:
MatchingFailed

Next State:
WaitingForRetry


---

# BR-3xx — Provider Acceptance

## BR-301

A Provider may accept an offer only while it is valid.

---

## BR-302

An expired offer cannot be accepted.

---

## BR-303

A Provider may reject an offer only while it is valid.

---

## BR-304

An accepted offer permanently closes the offer.

---

## BR-305

A rejected offer permanently closes the offer.

---

## BR-306

An expired offer permanently closes the offer.

---

## BR-307

A closed offer cannot receive another response.

---

## BR-308

If an offer expires, the Session enters WaitingForRetry.

---

## BR-309

Offer expiration is triggered by an external event.


---

# Transition Review #1

## Scope

Review the following Business Rule groups:

- BR-1xx — Session Creation
- BR-2xx — Matching
- BR-3xx — Provider Acceptance

## Review Checklist

### Traceability

- [ ] Every Business Rule maps to at least one Transition.
- [ ] Every Transition is justified by at least one Business Rule.

### State Integrity

- [ ] Every transition starts from a valid Session State.
- [ ] Every transition ends in a valid Session State.
- [ ] No transition skips mandatory states.
- [ ] Terminal states have no outgoing transitions.

### Event Integrity

- [ ] Every transition produces at most one primary Domain Event.
- [ ] Every Domain Event represents a completed business fact.

### Command Integrity

- [ ] Every Command has exactly one owning Actor.
- [ ] Every Command is valid only for its Current State.

## Review Result

PENDING


---

# Policy Model

Policies coordinate business decisions that span time, retries, or multiple Bounded Contexts.

Policies are not part of the Session Aggregate.

Policies observe Domain Events and may issue Commands.

Policies never modify Aggregate state directly.

---

## Initial Policies

### Retry Matching Policy

Observes:

- MatchingFailed
- ProviderRejectedOffer
- ProviderOfferExpired

May issue:

- RetryMatching

---

### Offer Expiration Policy

Observes:

- ProviderOfferSent

May issue:

- ExpireProviderOffer


---

# Policy Design Principles

## Purpose

Policies coordinate business workflows that cannot be owned by a single Aggregate.

Policies react to Domain Events.

Policies evaluate business conditions.

Policies may issue Commands.

Policies never modify Aggregate state directly.

Policies never bypass Aggregate invariants.

Policies are stateless.

---

## Policy Responsibilities

A Policy may:

- Observe one or more Domain Events.
- Evaluate business conditions.
- Coordinate multiple Bounded Contexts.
- Issue Commands.

A Policy must never:

- Change Aggregate state directly.
- Access Aggregate internals.
- Publish fake Domain Events.
- Contain persistence logic.


---

# Session Policy Catalog

## POL-101

Retry Matching Policy

Purpose:

Request another matching attempt after a recoverable failure.

---

## POL-102

Offer Expiration Policy

Purpose:

Expire Provider Offers that exceed the configured timeout.

---

## POL-103

Session Timeout Policy

Purpose:

Close abandoned Sessions.

---

## POL-104

Cancellation Approval Policy

Purpose:

Determine whether cancellation is permitted according to business rules.


---

# BR-4xx — Service Execution Rules

## BR-401

Only the assigned Provider may begin service execution.

---

## BR-402

Service execution may begin only after the Provider has arrived.

---

## BR-403

A Session may enter InProgress only once.

---

## BR-404

A Session in progress cannot return to any previous operational state.

---

## BR-405

Service execution requires an assigned Provider.

---

## BR-406

Service execution requires an active Customer Session.

---

## BR-407

A Session in progress may not be reassigned to another Provider.


---

# BR-4xx Transition Mapping

## BR-401

Transition:
StartService

Actor:
Provider

Current State:
ProviderArriving

Next State:
InProgress

---

## BR-402

Precondition:

Provider has arrived.

---

## BR-403

Constraint:

The Session may transition to InProgress exactly once.

---

## BR-404

Constraint:

Backward state transitions are prohibited.

---

## BR-405

Precondition:

ProviderAssigned == true

---

## BR-406

Precondition:

Customer Session is active.

---

## BR-407

Constraint:

ProviderId becomes immutable after service starts.


---

# BR-5xx — Cancellation Rules

## BR-501

A cancellation request must specify its initiator.

---

## BR-502

Only the Customer, the assigned Provider, or an authorized Policy may request cancellation.

---

## BR-503

A completed Session cannot be cancelled.

---

## BR-504

A cancelled Session cannot receive another cancellation request.

---

## BR-505

Cancellation eligibility depends on the current Session state.

---

## BR-506

A cancellation request does not necessarily cancel the Session.

---

## BR-507

A successful cancellation moves the Session to the Cancelled terminal state.

---

## BR-508

Cancellation consequences are handled outside the Session Aggregate.


---

# BR-5xx Transition Mapping

## BR-501

Command:
RequestCancellation

Requires:
Cancellation Initiator

---

## BR-502

Allowed Actors:

- Customer
- Assigned Provider
- Cancellation Policy

---

## BR-503

Constraint:

Completed → CancelSession

Forbidden

---

## BR-504

Constraint:

Cancelled → CancelSession

Forbidden

---

## BR-505

Precondition:

Cancellation rules are evaluated according to the current Session state.

---

## BR-506

Result:

CancellationRequested

does not imply

SessionCancelled.

---

## BR-507

Transition:

Current State:
Any cancellable state

↓

SessionCancelled

↓

Cancelled

---

## BR-508

Outside Aggregate:

- Refunds
- Fees
- Notifications
- Ratings
- Analytics


---

# BR-6xx — Completion Rules

## BR-601

Only an InProgress Session may be completed.

---

## BR-602

Only the assigned Provider may request service completion.

---

## BR-603

A completed Session enters the Completed terminal state.

---

## BR-604

A completed Session cannot be modified.

---

## BR-605

A completed Session cannot return to any previous state.

---

## BR-606

Service completion publishes exactly one SessionCompleted Domain Event.

---

## BR-607

Business consequences of completion are handled outside the Session Aggregate.


---

# BR-6xx Transition Mapping

## BR-601

Current State:
InProgress

Command:
CompleteService

Next State:
Completed

---

## BR-602

Actor:
Assigned Provider

---

## BR-603

Transition:

InProgress

↓

Completed

---

## BR-604

Constraint:

Completed is immutable.

---

## BR-605

Constraint:

No outgoing transitions exist from Completed.

---

## BR-606

Produced Event:

SessionCompleted

---

## BR-607

Outside Aggregate:

- Rating
- Payment Settlement
- Notification
- Analytics
- Customer History


---

# Session Coverage Matrix

## Lifecycle Coverage

| Phase | Rules |
|---------|--------|
| Session Creation | BR-1xx |
| Matching | BR-2xx |
| Provider Acceptance | BR-3xx |
| Service Execution | BR-4xx |
| Cancellation | BR-5xx |
| Completion | BR-6xx |
| Retry & Timeout | BR-7xx |
| Exceptional Cases | BR-8xx |

---

## Verification

Every lifecycle phase must have:

- Business Rules
- Transition Mapping
- Commands
- Domain Events
- Policies
- Tests


---

# BR-7xx — Retry & Timeout Rules

## BR-701

Retry decisions are made only by Policies.

---

## BR-702

A Retry may only be requested while the Session is in WaitingForRetry.

---

## BR-703

Retry attempts must respect configured retry limits.

---

## BR-704

Retry timeout is evaluated outside the Session Aggregate.

---

## BR-705

An expired Session cannot be retried.

---

## BR-706

Retry transitions the Session from WaitingForRetry to WaitingForMatch.

