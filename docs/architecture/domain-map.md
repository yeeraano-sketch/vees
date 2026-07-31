# Domain Map

## Strategic Domains

Core Business
Communication
Trust
Financial
Administration

---

## Context Relationships

Customer
    │
    ▼
Session
    │
    ▼
Matching
    │
    ▼
Notification

Session
    │
    ▼
Rating
    │
    ▼
Reputation
    │
    ├─────────────► Recommendation
    │
    ├─────────────► Badge
    │
    └─────────────► Fraud Detection

Subscription
    │
    ▼
Session

Payment
    │
    ▼
Session


---

## Relationship Types

Customer -> Session

Shared Identity

---

Session -> Matching

Domain Event

---

Matching -> Notification

Domain Event

---

Session -> Rating

Domain Event

---

Rating -> Reputation

Published Event

---

Reputation -> Recommendation

Read Model

---

Reputation -> Badge

Read Model

---

Reputation -> Fraud Detection

Analytics

