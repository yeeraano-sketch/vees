# Rating Context

## Purpose

The Rating Context is responsible for collecting, validating, storing and publishing ratings after a completed Session.

Ratings provide reputation information but never modify completed business transactions.


---

# Responsibility

## Rating Owns

- Ratings
- Rating Scores
- Rating Comments
- Rating History
- Rating Eligibility

---

## Rating Does Not Own

- Session
- Matching
- Notification
- Payment
- Customer
- Provider

Rating only references completed Sessions.


---

# Aggregate

Aggregate Root

Rating

---

## Responsibilities

Rating owns:

- Rating Score
- Rating Comment
- Rating Author
- Rating Target
- Rating Timestamp

Rating does not own:

- Session
- Matching
- Notification
- Reputation


---

# Invariants

## INV-401

A Rating belongs to exactly one completed Session.

---

## INV-402

A Rating has exactly one Author.

---

## INV-403

A Rating has exactly one Target.

---

## INV-404

A Rating may be submitted only once by the same Author for the same Session.

---

## INV-405

RatingScore must always be within the allowed range.

---

## INV-406

A submitted Rating is immutable.

---

## INV-407

Author and Target must be different Participants.

---

## INV-408

Only Session participants may create Ratings.

---

## INV-409

A Rating always references an existing completed Session.


---

# Mini Event Storming

## Happy Path

RatingEnabled

↓

RatingCreated

↓

RatingSubmitted

↓

RatingPublished

---

## Invalid Flow

RatingRejected

---

## Reputation Flow

RatingPublished

↓

ReputationUpdated


---

# State Catalog

## Created

Rating Aggregate has been created.

---

## Submitted

Rating has been submitted by the Author.

---

## Published

Rating event has been published.

Terminal State.

---

## Rejected

Rating submission rejected.

Terminal State.


---

# Business Rule Classification

| Prefix | Category |
|---------|----------|
| BR-1xx | Rating Creation |
| BR-2xx | Rating Submission |
| BR-3xx | Rating Publication |
| BR-4xx | Reputation Integration |
| BR-5xx | System Integrity |


---

# Error Model

| Code | Description |
|------|-------------|
| RATING-001 | Session not completed |
| RATING-002 | Rating already exists |
| RATING-003 | Invalid score |
| RATING-004 | Author is not a session participant |
| RATING-005 | Author and Target are identical |
| RATING-006 | Rating is immutable |


---

# Test Matrix

## Aggregate

- Rating creation
- Rating submission
- Duplicate prevention
- Immutable after submission

---

## Value Objects

- RatingScore
- RatingComment
- RatingAuthor
- RatingTarget

---

## Contracts

- RatingPublished Contract


---

# Architecture Review

- [x] Aggregate
- [x] Invariants
- [x] Business Rules
- [x] Commands
- [x] Events
- [x] Contracts
- [x] Error Model
- [x] Tests

Status:

PASSED

---

# Rating Context v1.0

Status:

FROZEN

Architecture Review:

PASSED

Implementation Readiness:

PASSED
