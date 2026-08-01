     دستور منصة "وصل" (Wasl Platform Constitution)

المرحلة صفر: الأساس المتين (Phase 0: The Foundation)

1. الرؤية والهدف (Vision & Goal)

الهدف: بناء منصة خدمات ميدانية (Field Service Platform) وليس مجرد تطبيق تاكسي.
الرؤية التقنية: نظام يتكون من محركات مستقلة (Engines) تتواصل عبر الأحداث (Events)، مبنية على نواة صلبة (Core) غير مرتبطة بأي واجهة (Telegram, Mobile App, Web). "تطبيق التاكسي" و"تطبيق التوصيل" هما مجرد تطبيقات (Apps) مبنية فوق هذه المنصة.

---

2. اللغة الموحدة (Ubiquitous Language)

هذا قاموس النظام. ممنوع استخدام أي مصطلح خارج هذا التعريف في الكود أو النقاشات.

المصطلح (Term) التعريف الدقيق (Definition)
Customer العميل الذي يطلب الخدمة.
Provider مقدم الخدمة (يشمل السائق، المندوب، أو أي فئة مستقبلية).
Service نوع الخدمة المقدمة (مثل: Taxi, Delivery). هذا ليس كياناً، بل خاصية.
ServiceSession الحاوية الذرية لدورة حياة أي خدمة من البداية إلى النهاية. هذا هو الكيان الأهم في النظام.
Order طلب الخدمة الأولي قبل وجود موفر خدمة. يتحول إلى ServiceSession عند المطابقة.
Match عملية تخصيص موفر خدمة لطلب ما، وتحويله إلى ServiceSession.
Booking طلب خدمة مجدول لوقت لاحق. (نوع من الـ Order المستقبلي).
Ride المرحلة الزمنية داخل ServiceSession من حالة Started حتى Finished.
Availability حالة مزود الخدمة وليس المركبة. (Offline, Online, Busy).
Vehicle المركبة التي يستخدمها مزود الخدمة.

---

3. القوانين الثابتة (Invariants)

هذه ليست مجرد قواعد عمل، بل قوانين النظام. إذا انتهك أي منها، فهذا خطأ برمجي (Bug) وليس استثناءً. لا يمكن كسرها أبداً.

1. تفرد الجلسة: الـ ServiceSession لا يمكن أن تمتلك أكثر من Provider واحد.
2. تفرد المهمة: الـ Provider لا يمكن أن يمتلك أكثر من ServiceSession نشطة (Active) في نفس الوقت.
3. أحادية التدفق: الـ ServiceSession لا يمكنها القفز بين الحالات. الانتقالات تتم فقط عبر المسارات المحددة في آلة الحالة (State Machine).
4. ثبات النهاية: أي ServiceSession في حالة نهائية (Finished, Cancelled) لا يمكنها الانتقال إلى أي حالة أخرى.
5. تكامل الدفع: لا يمكن إنشاء أكثر من Payment ناجح لنفس الـ ServiceSession.
6. تكامل التقييم: لا يمكن إنشاء أكثر من Rating واحد لكل طرف (Customer/Provider) لنفس الـ ServiceSession.

---

4. الكيانات الأساسية وآلات الحالة (Core Entities & State Machines)

أ. Provider (مزود الخدمة)

· Offline: غير متصل.
· Online: متصل وغير مشغول. يمكنه استقبال طلبات.
· Reserved: تم حجزه لجلسة مستقبلية (Booking).
· Busy: في جلسة نشطة الآن (بعد ProviderAccepted وحتى Finished).
· Suspended: موقوف من الإدارة أو Policy Engine.

ب. ServiceSession (قلب النظام)

· Created: تم إنشاء الطلب.
· Searching: جارٍ البحث عن مزود خدمة.
· Matched: تم العثور على مزود خدمة وإرسال الطلب إليه.
· ProviderAccepted: قبل مزود الخدمة الطلب. تم إنشاء الجلسة رسمياً.
· ProviderEnRoute: مزود الخدمة في طريقه إلى نقطة الالتقاء.
· ProviderArrived: وصل مزود الخدمة إلى نقطة الالتقاء.
· InService: بدأ تنفيذ الخدمة (بداية الـ Ride في التاكسي).
· Completed: انتهت الخدمة بنجاح. (حالة شبه نهائية، بانتظار الدفع والتقييم).
· Cancelled: ألغيت الخدمة.
· Archived: تمت أرشفة الجلسة بعد استكمال جميع الإجراءات.

ج. Payment (المدفوعات)

· Pending
· Authorized
· Captured
· Refunded
· Failed

---

5. معمارية المحركات (Engines Architecture)

النظام مبني على 8 محركات أساسية تتواصل عبر مركز الأحداث (Integration Hub).

1. Integration Hub (محور التكامل): العمود الفقري. يضمن توجيه الأحداث بين المحركات دون أن يعرف أي محرك تفاصيل الآخر.
2. Core Engine: محرك منطق الأعمال. ينسق عملية إنشاء الجلسة، تحديث الحالة، والتحقق من Invariants.
3. Session Engine: يدير دورة حياة الـ ServiceSession كاملة. هو المسؤول عن حالاتها وانتقالاتها.
4. Dispatch Engine: عقل توزيع الطلبات. يستخدم خوارزمية Dispatch Score (المسافة، التقييم، مدة الانتظار...) لترشيح أفضل مزود خدمة.
5. Policy Engine (Rule Engine): دماغ القواعد. يستقبل الأحداث ويقرر الإجراءات (فرض غرامة، حظر، إرسال تحذير) بناءً على القواعد التعريفية. لا ينفذ عمليات على الجلسة، بل يصدر أوامر للـ Core Engine.
6. Scheduler Engine: مسؤول عن كل ما هو زمني (الحجوزات، العقوبات المؤقتة، التذكيرات).
7. Notification Engine: مسؤول فقط عن إرسال الإشعارات للعالم الخارجي بعد استقبال حدث.
8. Recovery Engine: مسؤول عن التعافي من الفشل. عند اتصال أي طرف، يجيب على سؤال واحد: "ما هي جلستي النشطة الآن؟".

---

6. مصفوفة الفشل (Failure Matrix)

السيناريو (Scenario) الحالة الحالية (Current State) سلوك النظام (System Behavior)
انقطع الإنترنت عن الـ Provider ProviderEnRoute, InService الجلسة تبقى حية. النظام يعتمد آخر موقع معروف. إذا عاد خلال المهلة، تكمل الجلسة. إذا انتهت المهلة، يتم إلغاء الجلسة وتعويض العميل.
تعطل Redis أي حالة النظام يستمر بالعمل من قاعدة البيانات مباشرة. يفقد الأداء المؤقت لكنه لا يتوقف. يتم استعادة الـ Cache لاحقاً.
انقطع WebSocket أي حالة يعود كل عميل (بوت) تلقائياً إلى وضع Polling كل 5 ثوانٍ حتى يعود الاتصال.
تم إرسال Webhook مرتين Searching يتم تجاهل الثاني بسبب Idempotency Key المرفق مع كل طلب.
قبل الـ Provider ثم مات الخادم Matched -> (خادم) عند عودة الخادم، يقرأ كل الجلسات النشطة ويعيد بنائها. يجد الجلسة في حالة Matched ويكملها لـ ProviderAccepted.
رفض Telegram إرسال رسالة أي حالة يضع الـ Notification Engine الإشعار في Dead Letter Queue للمراقبة والمحاولة لاحقاً.
تجاوز الـ Queue حجماً معيناً أي حالة يتم تشغيل Alert فوري للإدارة، ويمكن تفعيل Circuit Breaker لإيقاف استقبال طلبات جديدة مؤقتاً.
العميل يحذف البوت أثناء الجلسة InService الـ Provider لا يرى فرقاً. تكمل الجلسة بشكل طبيعي. يتم إشعار الـ Provider بأن التواصل مع العميل مفقود.

---

7. استراتيجية التطور (Evolution Strategy)

النظام مصمم حول المفهوم المجرد ServiceSession. التاكسي والتوصيل هما Service من نوع Taxi و Delivery.
لإضافة خدمة جديدة (مثلاً: "شحن"):

1. إضافة النوع Shipping إلى جدول Service.
2. إضافة واجهة المستخدم الخاصة به في بوت العميل والموفر.
3. لا يتم تعديل Core Engine أو Session Engine. يتم فقط تمديدهما.

---

8. متطلبات الأداء والمراقبة (SLA & Monitoring)

· SLOs (مؤشرات الأداء):
  · زمن إنشاء الطلب (Order Created): < 300ms.
  · زمن قبول الطلب (ProviderAccepted): < 100ms بعد ضغط الموفر.
  · زمن إرسال الإشعار: < 3 ثوانٍ.
  · زمن استعادة الحالة (Recovery): < 5 ثوانٍ.
· Alerts (التنبيهات):
  · متوسط زمن قبول السائق > 15 ثانية.
  · معدل إلغاء العميل > 8%.
  · حجم الـ Queue > 500 مهمة.
  · عدد الجلسات الفاشلة في الدقيقة > 5.

---

بهذا الدستور، تكون نسبة كبيرة من القرارات المعمارية قد حُسمت. إنه يمثل الاتفاق النهائي بيننا قبل بدء رحلة البناء.

هل تريد أن نبدأ المرحلة التالية: بناء النواة (Core Engine & Session Engine) بناءً على هذا الدستور؟  ممتاز، سنبدأ إذًا بأول وثيقة في Platform Blueprint، وهي أهم وثيقة في النظام كله.


---

Platform Blueprint

الفصل الأول: Canonical Event & Command Model

الإصدار: 1.0 (Draft)


---

1. فلسفة النظام

النظام يعتمد على Event-Driven Architecture.

وهذا يعني أن المحركات لا تستدعي بعضها مباشرة.

بدلاً من ذلك:

Command
      │
      ▼
Core Engine
      │
      ▼
State Changed
      │
      ▼
Domain Event
      │
      ▼
Integration Hub
      │
 ┌────┼────┬─────┬─────┐
 ▼    ▼    ▼     ▼     ▼
Policy Dispatch Notify Audit Scheduler

القاعدة الذهبية:

> Commands تطلب تنفيذ شيء، Events تعلن أن شيئًا قد حدث.




---

2. النموذج القياسي للأحداث (Canonical Event)

جميع الأحداث في النظام يجب أن تتبع هذا الشكل دون استثناء.

{
  "eventId": "UUID",
  "eventType": "SessionAccepted",
  "aggregateType": "ServiceSession",
  "aggregateId": "UUID",

  "version": 1,

  "occurredAt": "2026-07-30T12:00:00Z",

  "correlationId": "UUID",

  "causationId": "UUID",

  "producer": "SessionEngine",

  "payload": {}
}


---

تعريف الحقول

الحقل	الوصف

eventId	معرف الحدث
eventType	نوع الحدث
aggregateType	نوع الكيان
aggregateId	معرف الكيان
version	إصدار الحدث
occurredAt	وقت UTC
correlationId	يربط الأحداث التابعة لنفس العملية
causationId	الحدث أو الأمر الذي سبب هذا الحدث
producer	المحرك الذي أنشأ الحدث
payload	بيانات الحدث



---

3. قواعد الأحداث (Event Rules)

Rule 1

الأحداث Immutable.

لا يتم تعديل أي حدث بعد حفظه.

إذا حصل خطأ:

ينشأ Event جديد.

ولا يعدل القديم.


---

Rule 2

الحدث يمثل حقيقة فقط.

مثال صحيح

ProviderAccepted

مثال خاطئ

AcceptProviderMaybe


---

Rule 3

الحدث لا يحمل بيانات واجهات المستخدم.

مثال خاطئ

{
"name":"Ahmed",
"avatar":"..."
}

بل

{
"providerId":"..."
}


---

Rule 4

كل حدث له Aggregate واحد فقط.

مثلاً

ServiceSession

ولا يجوز

Session

+

Payment

في نفس الحدث.


---

Rule 5

كل Event له Version.

حتى نستطيع تطوير النظام مستقبلاً.


---

4. النموذج القياسي للأوامر (Canonical Command)

كل أمر في النظام يجب أن يكون بالشكل التالي

{
"commandId":"UUID",

"commandType":"AcceptSession",

"aggregateId":"UUID",

"issuedAt":"UTC",

"requestedBy":"Provider",

"requestedById":"UUID",

"payload":{}
}


---

قواعد الأوامر

الأوامر تبدأ دائماً بفعل.

مثل

CreateOrder

AcceptSession

RejectSession

CancelSession

StartService

FinishService

ChangeDestination

UpdateLocation

ولا تبدأ باسم.


---

5. تصنيف الأحداث


---

Session Events

SessionCreated

SessionSearching

SessionMatched

SessionAccepted

SessionStarted

SessionPaused

SessionResumed

SessionCompleted

SessionCancelled

SessionArchived


---

Dispatch Events

DispatchStarted

ProvidersSelected

ProviderNotified

ProviderAccepted

ProviderRejected

DispatchTimedOut

DispatchCompleted

DispatchFailed


---

Provider Events

ProviderOnline

ProviderOffline

ProviderBusy

ProviderAvailable

ProviderLocationUpdated

ProviderSuspended

ProviderRestored


---

Customer Events

CustomerCreated

CustomerLocationUpdated

DestinationChanged

CustomerCancelled

CustomerRated


---

Payment Events

PaymentInitiated

PaymentAuthorized

PaymentCaptured

PaymentFailed

PaymentRefunded


---

Communication Events

ChatStarted

MessageSent

MessageDelivered

MessageRead

VoiceCallRequested

EmergencyTriggered


---

Scheduler Events

BookingCreated

BookingActivated

RecurringBookingCreated

ReminderSent

PenaltyExpired

AutoCancelExecuted


---

Recovery Events

RecoveryStarted

RecoveryCompleted

ConnectionLost

ConnectionRestored


---

Policy Events

PolicyEvaluated

PenaltyApplied

RewardGranted

ProviderBlocked

CustomerBlocked

WarningIssued


---

6. تصنيف الأوامر

Session Commands

CreateSession

AcceptSession

RejectSession

CancelSession

ArchiveSession

RestoreSession


---

Dispatch Commands

StartDispatch

NotifyProviders

RetryDispatch

StopDispatch


---

Provider Commands

GoOnline

GoOffline

UpdateLocation

ArrivePickup

StartWaiting

FinishWaiting

StartService

FinishService


---

Customer Commands

CreateOrder

CancelOrder

ChangeDestination

ShareLiveLocation

SendMessage


---

Payment Commands

AuthorizePayment

CapturePayment

RefundPayment


---

Administration Commands

SuspendProvider

RestoreProvider

SuspendCustomer

RestoreCustomer

BroadcastNotification


---

7. العلاقة بين Commands و Events

مثال عملي:

Customer

↓

CreateOrder Command

↓

Core Engine

↓

OrderCreated Event

↓

Dispatch Engine

↓

DispatchStarted Event

↓

ProviderNotified Event

↓

Provider

↓

AcceptSession Command

↓

Session Engine

↓

SessionAccepted Event

↓

Notification Engine

↓

Telegram Bot

لاحظ أن المحركات لا تتصل ببعضها مباشرة.

كل شيء يمر عبر Integration Hub.


---

8. قاعدة تسمية الأحداث

Event

يصف شيئًا انتهى.

مثل

PaymentCaptured

وليس

CapturePayment


---

9. قاعدة تسمية الأوامر

Command

هو فعل.

مثل

CapturePayment

وليس

PaymentCaptured


---

10. الأحداث المحظورة

لا يسمح بوجود أحداث عامة مثل

DataChanged

ObjectUpdated

SomethingHappened

Event1

DriverAction

كل حدث يجب أن يكون واضحًا ودقيقًا.


---

مراجعة معمارية (Architect Review)

هذه الوثيقة قوية جدًا، لكنني سأقترح تحسينين إضافيين قبل اعتمادها نهائيًا، لأنهما سيؤثران على المنصة مستقبلًا:

1. إضافة Event Classification

ليس كل حدث من نفس النوع. أقترح تصنيف الأحداث إلى:

Domain Events: أحداث الأعمال الأساسية (SessionAccepted, PaymentCaptured).

Integration Events: أحداث موجهة للمحركات أو الأنظمة الخارجية.

System Events: أحداث البنية التحتية (ConnectionLost, RecoveryCompleted).


هذا يمنع خلط أحداث الأعمال مع أحداث التشغيل.

2. إضافة Event Metadata

بدل أن يكون payload فقط، يكون لكل حدث قسم metadata اختياري يحتوي على معلومات مثل:

tenantId (إذا دعمت المنصة عدة شركات مستقبلًا).

traceId (لتتبع الطلب عبر الخدمات).

source (Telegram Bot، Admin Panel، Mobile App).

schemaVersion (لتطوير الحدث دون كسر التوافق).


بهذين التحسينين سيكون لدينا نموذج أحداث يمكن أن يستمر لسنوات دون الحاجة إلى إعادة تصميمه، وسيكون جاهزًا للتوسع إلى منصة مؤسسية متعددة الخدمات والواجهات.     بكل تأكيد. لكن قبل أن نبدأ أريد أن أوضح شيئًا مهمًا.

ما كتبناه خلال هذا النقاش لم يعد مجرد أفكار أو مخطط أولي، بل أصبح مشروع منصة (Platform) كامل. لذلك لا ينبغي أن يكون مجرد رسالة داخل المحادثة، بل يجب أن يتحول إلى وثيقة هندسية رسمية (Software Architecture Specification).

وأرى أن الدستور النهائي لن يكون عشر صفحات، بل سيكون تقريبًا 150 إلى 250 صفحة موزعة على عدة فصول، وهو ما تفعله الشركات الكبرى عند بناء أنظمة بهذا الحجم.


---

الهيكل النهائي الذي أقترحه

بدلاً من وثيقة صغيرة، سنبني دستور منصة وصل (Wasl Platform Architecture Specification).

وسيكون المرجع الوحيد للمشروع.


---

المجلد الأول

Vision & Philosophy

يتضمن:

رؤية المشروع

رسالة المشروع

أهداف المنصة

لماذا تم اختيار Telegram

لماذا المنصة وليست تطبيقًا

فلسفة التصميم

المبادئ الهندسية

Non Functional Requirements

Engineering Principles



---

المجلد الثاني

Platform Constitution

يتضمن:

Ubiquitous Language

Domain Model

Invariants

Business Rules

Design Principles

Architecture Principles

ADR

Coding Philosophy



---

المجلد الثالث

Core Architecture

يتضمن شرحًا كاملاً لـ

Core Engine

Session Engine

Dispatch Engine

Policy Engine

Rule Engine

Scheduler Engine

Notification Engine

Recovery Engine

Integration Hub

Audit Engine

Chat Engine

Payment Engine


مع مخططات لكل محرك.


---

المجلد الرابع

Blueprint

ويحتوي

Canonical Event Model

Canonical Command Model

Event Catalog

Command Catalog

Event Payload

Metadata

Error Catalog

API Contract

WebSocket Contract

Queue Contract



---

المجلد الخامس

Domains

مثل

Customer Domain

Provider Domain

Vehicle Domain

Session Domain

Payment Domain

Notification Domain

Support Domain

Booking Domain

Recurring Booking Domain

Loyalty Domain

Fraud Domain

Pricing Domain


---

المجلد السادس

State Machines

لكل كيان.

وليس للجلسة فقط.

مثل

Customer

Provider

Vehicle

Booking

Session

Payment

Support Ticket

Chat

Notification


---

المجلد السابع

Failure Matrix

وأعتبره من أهم أجزاء المشروع.

يشمل أكثر من 300 سيناريو.

مثلاً

انقطاع الكهرباء.

سقوط Redis.

سقوط PostgreSQL Replica.

انقطاع الإنترنت عن السائق.

حذف البوت.

إعادة تشغيل السيرفر.

الضغط المزدوج.

ضغط قبول الطلب مرتين.

إرسال Webhook مرتين.

تأخر Queue.

تأخر GPS.

تغيير الوقت.

تغيير المنطقة الزمنية.

امتلاء القرص.

انتهاء الذاكرة.

انقطاع Telegram.

انقطاع Google Maps.

وغيرها...


كل حالة سيكون لها:

سبب.

تأثير.

طريقة الكشف.

Recovery Strategy.

Logging.

Alert.



---

المجلد الثامن

Security

يشمل

Authentication

Authorization

Permissions

Encryption

Secrets

Rate Limiting

Audit Logs

GPS Spoof Detection

Fraud Detection

Replay Protection

Idempotency

JWT

Bot Verification

Webhook Security


---

المجلد التاسع

Scalability

يشمل

Horizontal Scaling

Vertical Scaling

Read Replicas

Redis

Caching

Partitioning

Sharding

Load Balancer

Queues

Circuit Breaker

Retry

Dead Letter Queue

Graceful Shutdown

Auto Scaling

Performance Targets


---

المجلد العاشر

Telegram Layer

كل شيء خاص بالبوتات.

Bot Customer

Bot Provider

Bot Admin

Chat Room

Inline Buttons

Location

Voice

Media

Keyboard

Callback

Polling

Webhook


---

المجلد الحادي عشر

Admin Panel

يشمل

Dashboard

Analytics

Monitoring

Support

Pricing

Drivers

Customers

Permissions

Reports

Audit

Logs

Feature Flags

Settings


---

المجلد الثاني عشر

Algorithms

ويحتوي

Dispatch Score

Dynamic Pricing

Fraud Score

Reliability Score

Cancellation Score

Matching

Ranking

Waiting Fee

Penalty

Reward

Loyalty

ETA

Distance


---

المجلد الثالث عشر

Database

ERD

Tables

Indexes

Constraints

PostGIS

Redis Keys

Caching

Migration Rules

Soft Delete

Archive

Backups

Restore


---

المجلد الرابع عشر

DevOps

Docker

CI/CD

Git Strategy

Monitoring

Grafana

Prometheus

Logs

Tracing

OpenTelemetry

Health Checks


---

المجلد الخامس عشر

Testing

Unit

Integration

Contract

Stress

Load

Chaos

Recovery

Performance


---

المجلد السادس عشر

Development Standards

Naming

Folder Structure

DDD

SOLID

Clean Architecture

Code Review

Commit Convention

Branching

Versioning


---

النتيجة النهائية

هذه الوثيقة لن تكون مجرد "دستور"، بل ستكون المرجع الرسمي الوحيد للمشروع. أي مطور ينضم للفريق، أو أي قرار معماري جديد، سيعود إليها أولًا.

وهناك قرار أخير أقترحه قبل كتابة أي سطر برمجي

لن نكتب هذه الوثيقة كملف واحد.

سنكتبها كـ كتاب هندسي احترافي، مقسم إلى إصدارات:

Version 1.0: الدستور الأساسي والمنصة.

Version 1.1: التوسعات والتحسينات.

Version 2.0: عند إضافة خدمات جديدة أو تغييرات معمارية كبيرة.


كل تعديل سيكون موثقًا، مع سجل للتغييرات (Changelog) وقرارات معمارية (ADR)، بحيث يبقى تاريخ تطور المنصة واضحًا وقابلًا للمراجعة.

هذا هو الأسلوب الذي أوصي به لبناء منصة بحجم وطموح "وصل". فهو يجعل المشروع قابلًا للتطوير لسنوات، ويقلل بشكل كبير من إعادة التصميم أو تراكم الديون التقنية مع نمو الفريق والمنتج.
