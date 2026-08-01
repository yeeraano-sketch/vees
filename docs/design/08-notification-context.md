# Notification Context

## Purpose

The Notification Context is responsible for delivering business notifications triggered by Domain Events.

Notification never owns business decisions.

Notification never changes business state.

Notification reacts to Domain Events and delivers notifications through supported channels.


---

# Responsibility

## Notification Owns

- Notification Requests
- Delivery Attempts
- Delivery Channels
- Delivery Status
- Delivery History

---

## Notification Does Not Own

- Session
- Matching
- Customer
- Provider
- Subscription
- Payment
- Rating

Notification only reacts to business events.


---

# Aggregate

Aggregate Root

NotificationDelivery

---

## Responsibilities

NotificationDelivery owns:

- Delivery lifecycle
- Delivery attempts
- Delivery status
- Delivery channel
- Delivery metadata

NotificationDelivery does not own:

- Session
- Matching
- Customer
- Provider


---

# Invariants

## INV-301

Each NotificationDelivery belongs to exactly one triggering Domain Event.

---

## INV-302

Each NotificationDelivery targets exactly one Recipient.

---

## INV-303

Each NotificationDelivery uses exactly one Delivery Channel.

---

## INV-304

A completed NotificationDelivery is immutable.

---

## INV-305

A failed NotificationDelivery is immutable.

---

## INV-306

Only one DeliveryAttempt may be active at any given time.

---

## INV-307

DeliveryStatus must always reflect the latest completed DeliveryAttempt.

---

## INV-308

A NotificationDelivery cannot be completed more than once.

---

## INV-309

Retry attempts are allowed only before completion.

---

## INV-310

Aggregate invariants must hold after every successful Command.


---

# Mini Event Storming

## Happy Path

NotificationRequested

↓

DeliveryStarted

↓

DeliverySucceeded

↓

DeliveryCompleted

---

## Failure Path

NotificationRequested

↓

DeliveryStarted

↓

DeliveryFailed

↓

RetryRequested

↓

DeliveryStarted

↓

DeliverySucceeded

↓

DeliveryCompleted

---

## Permanent Failure

NotificationRequested

↓

DeliveryStarted

↓

DeliveryFailed

↓

DeliveryAbandoned


---

# Mini Event Storming

## Happy Path

NotificationRequested

↓

DeliveryStarted

↓

DeliverySucceeded

↓

DeliveryCompleted

---

## Failure Path

NotificationRequested

↓

DeliveryStarted

↓

DeliveryFailed

↓

RetryRequested

↓

DeliveryStarted

↓

DeliverySucceeded

↓

DeliveryCompleted

---

## Permanent Failure

NotificationRequested

↓

DeliveryStarted

↓

DeliveryFailed

↓

DeliveryAbandoned


---

# State Catalog

## Objective

Define every valid state of the NotificationDelivery Aggregate.

States are mutually exclusive.

A NotificationDelivery is always in exactly one state.

---

## Created

NotificationDelivery has been created but delivery has not started.

---

## Delivering

The notification is currently being delivered through the selected channel.

---

## Retrying

A previous delivery attempt failed and another attempt is scheduled.

---

## Completed

Notification delivery completed successfully.

Terminal State.

---

## Failed

Notification delivery permanently failed.

Terminal State.


---

# Business Rule Classification

| Prefix | Category |
|---------|----------|
| BR-1xx | Delivery Initialization |
| BR-2xx | Delivery Execution |
| BR-3xx | Retry Management |
| BR-4xx | Delivery Completion |
| BR-5xx | System Integrity |

---

# BR-1xx — Delivery Initialization

## BR-101

A NotificationDelivery may be created only from a published Domain Event.

---

## BR-102

Each NotificationDelivery shall reference exactly one triggering Domain Event.

---

## BR-103

A NotificationDelivery always starts in the Created state.

---

## BR-104

Delivery may begin only from the Created state.

---

## BR-105

Delivery begins only through an explicit StartDelivery command.

---

## BR-106

Starting delivery transitions the NotificationDelivery to Delivering.


---

# BR-1xx Transition Mapping

## BR-101

Trigger:

Published Domain Event

---

## BR-102

Constraint:

Exactly one Triggering Event.

---

## BR-103

Transition:

CreateNotificationDelivery

↓

Created

---

## BR-104

Current State:

Created

Command:

StartDelivery

---

## BR-105

Initiator:

Notification Policy

---

## BR-106

Transition:

Created

↓

Delivering

Produced Event:

DeliveryStarted


---

# BR-2xx — Delivery Execution

## BR-201

Delivery may begin only while NotificationDelivery is in the Delivering state.

---

## BR-202

Exactly one DeliveryAttempt may be active at any given time.

---

## BR-203

A successful DeliveryAttempt completes the NotificationDelivery.

---

## BR-204

A failed DeliveryAttempt transitions the NotificationDelivery to Retrying or Failed according to Retry Policy.

---

## BR-205

NotificationDelivery does not perform message transmission itself.

---

## BR-206

Message transmission is delegated to a Channel Adapter.

---

## BR-207

Channel Adapters report only the delivery outcome.


---

# BR-2xx Transition Mapping

## BR-201

Current State:

Delivering

Command:

ExecuteDelivery

---

## BR-202

Constraint:

Exactly one active DeliveryAttempt.

---

## BR-203

Transition:

Delivering

↓

Completed

Produced Event:

DeliverySucceeded

---

## BR-204

Transition:

Delivering

↓

Retrying

or

↓

Failed

---

## BR-205

Aggregate Responsibility:

Track delivery lifecycle only.

---

## BR-206

Infrastructure Responsibility:

Email Adapter

SMS Adapter

Push Adapter

---

## BR-207

Adapter Result:

Success

Failure

Timeout


---

# BR-3xx — Retry Management

## BR-301

Retry may begin only after a failed DeliveryAttempt.

---

## BR-302

Only one DeliveryAttempt may be active.

---

## BR-303

Retry transitions NotificationDelivery from Retrying to Delivering.

---

## BR-304

Retry eligibility is determined by Retry Policy.

---

## BR-305

Retry limits are enforced outside the Aggregate.

---

## BR-306

Retry scheduling is outside the Aggregate.


---

# BR-3xx Transition Mapping

## BR-301

Current State:

Retrying

---

## BR-302

Constraint:

Exactly one active DeliveryAttempt.

---

## BR-303

Command:

StartRetry

Transition:

Retrying

↓

Delivering

---

## BR-304

Owner:

Retry Policy

---

## BR-305

Owner:

Retry Policy

---

## BR-306

Owner:

Scheduler


---

# BR-4xx — Delivery Completion

## BR-401

Only a successful DeliveryAttempt may complete a NotificationDelivery.

---

## BR-402

Completed NotificationDelivery is immutable.

---

## BR-403

Failed NotificationDelivery is immutable.

---

## BR-404

Exactly one DeliveryCompleted event shall be published.

---

## BR-405

Delivery completion finalizes the Aggregate lifecycle.


---

# BR-4xx Transition Mapping

## BR-401

Delivering

↓

Completed

---

## BR-402

Constraint:

Immutable Aggregate

---

## BR-403

Constraint:

Immutable Aggregate

---

## BR-404

Produced Event:

DeliveryCompleted

---

## BR-405

Terminal State


---

# BR-5xx — System Integrity

## BR-501

Duplicate Commands shall not change Aggregate state.

---

## BR-502

Duplicate Events shall be ignored.

---

## BR-503

Invalid transitions are prohibited.

---

## BR-504

Terminal states have no outgoing transitions.

---

## BR-505

Aggregate invariants shall hold after every successful Command.


---

# Transition Review

## Checklist

- [ ] Aggregate validated
- [ ] Invariants protected
- [ ] States complete
- [ ] Business Rules mapped
- [ ] Commands mapped
- [ ] Events mapped
- [ ] Policies validated
- [ ] Public Contracts reviewed

Status:

PENDING


---

# Implementation Readiness

## Aggregate

NotificationDelivery

---

## Entities

- DeliveryAttempt

---

## Value Objects

- Recipient
- DeliveryChannel
- DeliveryStatus

---

## Policies

- Retry Policy
- Channel Selection Policy

---

## Ports

- NotificationChannel

---

## Commands

- CreateNotificationDelivery
- StartDelivery
- StartRetry

---

## Domain Events

- NotificationRequested
- DeliveryStarted
- DeliverySucceeded
- DeliveryFailed
- DeliveryCompleted

Status:

READY FOR IMPLEMENTATION


---

# Notification Context v1.0

Status:

FROZEN

Implementation Readiness:

PASSED

Architecture Review:

PASSED

