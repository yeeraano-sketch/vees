# Matching Context

## Purpose

The Matching Context is responsible for selecting the most suitable eligible Provider for a Session.

Matching never owns the Session.

Matching never owns the Provider.

Matching coordinates Provider selection according to business rules and publishes the matching outcome.


---

# Responsibility

## Mission

The Matching Context is responsible for coordinating the Provider selection process for a Session.

Its responsibility begins when matching is requested and ends when the matching process reaches a final outcome.

Matching owns the matching process.

Matching does not own the Session.

Matching does not own the Provider.

Matching does not decide Provider eligibility.

Matching does not execute the service.


---

# Boundaries

## Matching Owns

- Matching Process
- Matching Attempts
- Candidate Selection
- Offer Coordination
- Matching Outcome

---

## Matching Does Not Own

- Session
- Customer
- Provider
- Subscription
- Payment
- Rating
- Notification


---

# Invariants

## INV-101

Each Session owns exactly one MatchingProcess.

---

## INV-102

A MatchingProcess belongs to exactly one Session.

---

## INV-103

A MatchingProcess may have at most one active MatchingAttempt.

---

## INV-104

A Provider may have at most one active Offer within a MatchingProcess.

---

## INV-105

Only one Provider Offer may be active at any given time.

---

## INV-106

A completed MatchingProcess is immutable.

---

## INV-107

A failed MatchingProcess is immutable.

---

## INV-108

MatchingOutcome may be assigned exactly once.

---

## INV-109

A MatchingProcess cannot be reopened after completion.

---

## INV-110

A new MatchingAttempt may begin only after the previous attempt has finished.


---

# Mini Event Storming

## Happy Path

MatchingRequested

↓

MatchingStarted

↓

CandidatesSelected

↓

ProviderOfferSent

↓

ProviderAcceptedOffer

↓

MatchingSucceeded

↓

MatchingCompleted

---

## Offer Rejected

ProviderRejectedOffer

↓

NextCandidateSelected

↓

ProviderOfferSent

---

## Offer Expired

ProviderOfferExpired

↓

NextCandidateSelected

↓

ProviderOfferSent

---

## No Candidate Available

CandidatesSelectionFailed

↓

MatchingFailed

---

## Retry Path

MatchingRetryRequested

↓

MatchingStarted


---

# Matching State Catalog

## Objective

Define every valid state of the MatchingProcess Aggregate.

States represent the internal lifecycle of a MatchingProcess.

States are mutually exclusive.

A MatchingProcess is always in exactly one state.

---

## Created

The MatchingProcess has been created but matching has not started.

---

## Searching

Candidate selection is currently in progress.

---

## WaitingForProviderResponse

A Provider Offer has been sent and the system is waiting for a response.

---

## Retrying

The previous matching attempt ended without success and another attempt may begin.

---

## Matched

A Provider accepted the Offer.

Matching succeeded.

---

## Failed

No eligible Provider could be matched.

Terminal State.

---

## Completed

Matching finished successfully.

Terminal State.


---

# Business Rule Classification

| Prefix | Category |
|---------|----------|
| BR-1xx | Matching Initialization |
| BR-2xx | Candidate Selection |
| BR-3xx | Offer Management |
| BR-4xx | Matching Completion |
| BR-5xx | Retry Rules |
| BR-6xx | System Integrity |

---

# BR-1xx — Matching Initialization

## BR-101

A MatchingProcess may be created only for an existing Session.

---

## BR-102

A MatchingProcess may be created only once for a Session.

---

## BR-103

Matching may begin only when requested by an authorized actor or Policy.

---

## BR-104

A newly created MatchingProcess always starts in the Created state.

---

## BR-105

Matching may start only from the Created state.

---

## BR-106

Starting Matching transitions the MatchingProcess to Searching.


---

# BR-1xx Transition Mapping

## BR-101

Command:
CreateMatchingProcess

Precondition:
Session exists.

---

## BR-102

Constraint:

Exactly one MatchingProcess per Session.

---

## BR-103

Allowed Initiators:

- Session Policy
- Authorized Application Service

---

## BR-104

Transition:

CreateMatchingProcess

↓

Created

---

## BR-105

Current State:

Created

Command:

StartMatching

---

## BR-106

Transition:

Created

↓

Searching

Produced Event:

MatchingStarted


---

# BR-2xx — Candidate Selection

## BR-201

Candidate selection may begin only while the MatchingProcess is in the Searching state.

---

## BR-202

Only eligible Providers may become Candidates.

---

## BR-203

A Candidate may appear only once within a MatchingProcess.

---

## BR-204

Candidate ordering is determined by the active Matching Strategy.

---

## BR-205

MatchingProcess does not determine Provider eligibility.

---

## BR-206

MatchingProcess does not determine Candidate ranking.

---

## BR-207

If no Candidates are available, Matching fails.


---

# BR-2xx Transition Mapping

## BR-201

Current State:

Searching

Command:

SelectCandidates

---

## BR-202

Precondition:

Provider Eligibility == Eligible

---

## BR-203

Constraint:

Candidate uniqueness is enforced.

---

## BR-204

Outside Aggregate:

Matching Strategy

---

## BR-205

Owned by:

Provider Context

---

## BR-206

Owned by:

Matching Strategy

---

## BR-207

Transition:

Searching

↓

Failed

Produced Event:

MatchingFailed


---

# BR-3xx — Offer Management

## BR-301

A Provider Offer may be issued only to a selected Candidate.

---

## BR-302

Only one Offer may be active at any given time.

---

## BR-303

An Offer may be answered only once.

---

## BR-304

An accepted Offer immediately completes the matching process successfully.

---

## BR-305

A rejected Offer permanently closes that Offer.

---

## BR-306

An expired Offer permanently closes that Offer.

---

## BR-307

A closed Offer cannot receive another response.

---

## BR-308

After a rejected or expired Offer, the MatchingProcess may continue with the next Candidate.

---

## BR-309

Offer expiration is handled by a Policy outside the Aggregate.


---

# BR-3xx Transition Mapping

## BR-301

Current State:

Searching

Command:

SendProviderOffer

Next State:

WaitingForProviderResponse

---

## BR-302

Constraint:

Exactly one active Offer.

---

## BR-303

Constraint:

Offer response is immutable.

---

## BR-304

Transition:

WaitingForProviderResponse

↓

Matched

Produced Event:

ProviderAcceptedOffer

---

## BR-305

Transition:

WaitingForProviderResponse

↓

Searching

Produced Event:

ProviderRejectedOffer

---

## BR-306

Transition:

WaitingForProviderResponse

↓

Searching

Produced Event:

ProviderOfferExpired

---

## BR-307

Constraint:

Closed offers reject further responses.

---

## BR-308

Command:

SelectNextCandidate

Current State:

Searching

---

## BR-309

Owned by:

Offer Expiration Policy


---

# BR-4xx — Matching Completion

## BR-401

Only a Matched MatchingProcess may enter the Completed state.

---

## BR-402

Matching completion assigns exactly one MatchingOutcome.

---

## BR-403

A completed MatchingProcess cannot be modified.

---

## BR-404

A completed MatchingProcess publishes exactly one MatchingCompleted Domain Event.

---

## BR-405

Matching completion notifies downstream Bounded Contexts through Domain Events only.


---

# BR-4xx Transition Mapping

## BR-401

Current State:

Matched

Command:

CompleteMatching

Next State:

Completed

---

## BR-402

Constraint:

MatchingOutcome is immutable.

---

## BR-403

Constraint:

Completed MatchingProcesses are immutable.

---

## BR-404

Produced Event:

MatchingCompleted

---

## BR-405

Consumers:

- Session Context
- Notification Context
- Analytics


---

# BR-5xx — Retry Rules

## BR-501

Retry may begin only from the Retrying state.

---

## BR-502

Retry starts a new MatchingAttempt.

---

## BR-503

Only one MatchingAttempt may be active.

---

## BR-504

Retry limits are enforced by Policies.

---

## BR-505

Retry timeout is evaluated outside the Aggregate.


---

# BR-5xx Transition Mapping

## BR-501

Current State:

Retrying

Command:

StartRetry

Next State:

Searching

---

## BR-502

Result:

New MatchingAttempt

---

## BR-503

Constraint:

Previous MatchingAttempt must be finished.

---

## BR-504

Owned by:

Retry Policy

---

## BR-505

Owned by:

Retry Timeout Policy


---

# BR-6xx — System Integrity

## BR-601

Duplicate Commands shall be ignored or rejected according to Aggregate rules.

---

## BR-602

Duplicate Domain Events shall not change Aggregate state.

---

## BR-603

Invalid state transitions are prohibited.

---

## BR-604

Terminal states have no outgoing transitions.

---

## BR-605

Aggregate invariants must hold after every successful Command.


---

# Transition Review

## Review Scope

- Business Rules
- State Catalog
- Transition Table
- Policies
- Commands
- Domain Events
- Invariants

---

## Checklist

### Aggregate Integrity

- [ ] Single Aggregate Root
- [ ] Invariants protected
- [ ] Aggregate owns its lifecycle

---

### State Integrity

- [ ] Every state is reachable
- [ ] No orphan states
- [ ] No orphan transitions
- [ ] Terminal states have no outgoing transitions

---

### Business Rules

- [ ] Every Business Rule maps to a Transition
- [ ] Every Transition is justified by a Business Rule

---

### Event Integrity

- [ ] Events represent completed business facts
- [ ] Events are immutable
- [ ] One publisher per Domain Event

---

### Policy Integrity

- [ ] Retry handled by Policy
- [ ] Offer expiration handled by Policy
- [ ] Strategy outside Aggregate

---

### Final Review

Status:

PENDING


---

# Matching Coverage Matrix

| Phase | Status |
|---------|--------|
| Responsibility | ✅ |
| Aggregate | ✅ |
| Invariants | ✅ |
| Event Storming | ✅ |
| State Catalog | ✅ |
| BR-1xx Initialization | ✅ |
| BR-2xx Candidate Selection | ✅ |
| BR-3xx Offer Management | ✅ |
| BR-4xx Completion | ✅ |
| BR-5xx Retry | ✅ |
| BR-6xx System Integrity | ✅ |

---

## Verification

Every phase contains:

- Business Rules
- Transition Mapping
- Commands
- Events
- Policies


---

# Matching Context v1.0

Status:

FROZEN

Architecture Review:

PASSED

