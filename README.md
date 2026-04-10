# 📊 VGT Dattrack — Sovereign Analytics Engine

[![License](https://img.shields.io/badge/License-AGPLv3-red?style=for-the-badge)](#)
[![Version](https://img.shields.io/badge/Version-1.4.0-brightgreen?style=for-the-badge)](#)
[![Status](https://img.shields.io/badge/Status-STABLE-brightgreen?style=for-the-badge)](#)
[![Encryption](https://img.shields.io/badge/Encryption-AES--256--GCM-purple?style=for-the-badge)](#)
[![DSGVO](https://img.shields.io/badge/DSGVO-Privacy_by_Design-blue?style=for-the-badge)](#)
[![Architecture](https://img.shields.io/badge/Architecture-DIAMANT_VGT_SUPREME-gold?style=for-the-badge)](#)
[![VGT](https://img.shields.io/badge/VGT-VisionGaia_Technology-red?style=for-the-badge)](https://visiongaiatechnology.de)

> *"Deine Daten. Deine Infrastruktur. Kein Dritter. Keine Kompromisse."*

---

## ⚠️ DISCLAIMER: EXPERIMENTAL R&D PROJECT

This project is a **Proof of Concept (PoC)** Wordpress Security Layer. It is **not** a Enterprise Plugin, and can be unsafe.

**Do not use this in critical production environments.** For enterprise-grade kernel-level protection, we recommend established Solutions.


## 🔍 Was ist VGT Dattrack?

VGT Dattrack ist eine **autarke Analytics-Engine** für absolute Datenhoheit. Während herkömmliche Tracking-Lösungen wie Google Analytics oder Matomo Daten an externe Server senden oder auf fremde Infrastruktur angewiesen sind, operiert Dattrack vollständig auf deiner eigenen Infrastruktur — kryptographisch isoliert, DSGVO-konform by Design, ohne eine einzige externe Abhängigkeit.

```
Google Analytics:    Deine Daten → Google Server → USA → Schrems II Problem
Matomo (Cloud):      Deine Daten → Matomo Server → Extern
VGT Dattrack:        Deine Daten → Dein Server → Dein Vault → Nur du
```
<img width="1747" height="1022" alt="Dattrack" src="https://github.com/user-attachments/assets/93efbd31-e0d4-44a4-86c6-f147afd55548" />

---

## 🏛️ Architektur — Aegis Protocol

```
Besucher kommt auf deine Website
         ↓
Micro-Consent UI (Blur-Effekt, asynchron)
         ↓
Ingestion Layer (Temporal Anomaly Detection)
         ↓
Aegis Kryptokern
→ IP-Hash via HMAC-SHA256 (Salted + Peppered)
→ Payload-Verschlüsselung AES-256-GCM
→ AAD-Bindung (Anti-Replay, Anti-Manipulation)
         ↓
VGT Vault (isoliert, außerhalb Web-Root)
→ Key-Rotation alle 30 Tage automatisch
→ Zero-Knowledge: Keine Rohdaten im Langzeitspeicher
         ↓
VGT_Aggregator Engine (O(1) Keyset Pagination)
→ Chunk-Verarbeitung (2000 Records/Zyklus)
→ Auto-Purge Rohdaten nach 7 Tagen
         ↓
VGT Command Center Dashboard
→ Live Sync / Echtzeit
→ CSV Export (on-the-fly Entschlüsselung)
→ PDF Analytical Matrix

OptOut Shortcode 
[vgt_dattrack_optout]

```

---

## 💎 Feature Set

| Feature | Beschreibung |
|---|---|
| **AES-256-GCM Verschlüsselung** | Vertraulichkeit + Authentizität jedes Datenpakets |
| **HMAC-SHA256 Anonymisierung** | IP-Adressen werden verperlt — nie im Klartext gespeichert |
| **AAD Payload-Bindung** | Verhindert Replay-Attacken und Manipulation |
| **Key-Rotation (30 Tage)** | Automatisiertes Aegis-Rotation-Protocol |
| **O(1) Keyset Pagination** | Kein Performance-Einbruch bei Millionen von Datensätzen |
| **Temporal Anomaly Detection** | DDoS-Schutz auf Ingestion-Ebene |
| **Micro-Consent UI** | DSGVO-konformer Consent-Layer mit Blur-Effekt |
| **Opt-Out Node** | Shortcode-Handler für vollständige Nutzerkontrolle [vgt_dattrack_optout] |
| **Zero-Knowledge Vault** | Keine unverschlüsselten Rohdaten im Langzeitspeicher |
| **Auto-Purge** | Automatische Bereinigung nach 7 Tagen |
| **Live Sync Dashboard** | Echtzeit-Synchronisation im VGT Command Center |
| **CSV Stream Export** | On-the-fly Entschlüsselung ohne RAM-Überlastung |
| **PDF Analytical Matrix** | Visuelle Telemetrie-Aufbereitung für strategische Entscheidungen |
| **Zero Dependencies** | Kein externes CDN, keine fremde Infrastruktur |

---

## 🔐 Kryptographische Spezifikationen

```
Verschlüsselung:    AES-256-GCM (Galois/Counter Mode)
Hashing:            HMAC-SHA256 (Salted & Peppered)
Payload-Bindung:    AAD (Additional Authenticated Data)
Key-Management:     Automatische Rotation alle 30 Tage
Key-Speicherung:    Außerhalb Web-Root (.htaccess + Nginx geschützt)
IP-Verarbeitung:    Rotating Master-Key + dynamischer Salt → nie Klartext
Replay-Schutz:      Zeitfenster-Validierung (Temporal Anomaly Detection)
```

---

## ⚖️ DSGVO Compliance — Privacy by Design

VGT Dattrack ist nicht nachträglich DSGVO-konform gemacht worden — es wurde **von Grund auf** nach Privacy-by-Design Prinzipien entwickelt.

### Warum das wichtig ist:

```
Schrems II (EuGH C-311/18):
→ Übertragung personenbezogener Daten in die USA rechtswidrig
→ Google Analytics → US-Server → DSGVO-Verstoß
→ Deutsche Gerichte: Abmahnungen bereits ausgesprochen

VGT Dattrack:
→ Kein einziger Request verlässt deine Infrastruktur
→ IP-Adressen werden strukturell anonymisiert
→ Zero-Knowledge: Nicht einmal du siehst Rohdaten
→ Vollständiger Opt-Out via Shortcode
→ Schrems II Problem: strukturell gelöst
```

### DSGVO-Komponenten:

| Anforderung | Umsetzung in Dattrack |
|---|---|
| **Datensparsamkeit** | Auto-Purge nach 7 Tagen, keine Langzeitspeicherung |
| **Zweckbindung** | Isolierter Vault, kein Datenaustausch |
| **Einwilligung** | Micro-Consent UI mit asynchroner Status-Speicherung |
| **Widerrufsrecht** | Opt-Out Node via Shortcode |
| **Technische Sicherheit** | AES-256-GCM, HMAC-SHA256, AAD |
| **Keine Drittübertragung** | Zero-Dependency, vollständig self-hosted |

---

## ⚡ Performance

```
Herkömmliche Analytics (OFFSET-Query):
→ 1.000 Datensätze:    schnell
→ 100.000 Datensätze:  langsam
→ 1.000.000 Datensätze: Timeout

VGT Dattrack (O(1) Keyset Pagination):
→ 1.000 Datensätze:    schnell
→ 100.000 Datensätze:  schnell
→ 1.000.000 Datensätze: schnell
→ Skaliert linear, nicht quadratisch
```

**Chunk-basierte Verarbeitung:** 2.000 Records pro Zyklus — PHP-Memory-Limits werden selbst bei massiven Datenbeständen nie überschritten.

---

## 📋 Technische Spezifikationen

```
VERSION           1.4.0 (Export Kernel)
ENCRYPTION        AES-256-GCM
HASHING           HMAC-SHA256 (Salted & Peppered)
DATENBANK         MySQL 8.0+ / MariaDB (InnoDB optimiert)
BACKEND           PHP 7.4+ (Strict Types Enabled)
FRONTEND          Vanilla JS (ESNext), CSS Grid/Flexbox
EXPORT            CSV (UTF-8 BOM), PDF (Print Matrix)
PROTOKOLL         VGT Aegis Protocol
KEY-ROTATION      Automatisch alle 30 Tage
DATA-LIFECYCLE    Auto-Purge Rohdaten nach 7 Tagen
PAGINATION        O(1) Keyset (Seek Method)
CHUNK-SIZE        2.000 Records/Zyklus
ARCHITEKTUR       DIAMANT VGT SUPREME
```

---

## 📊 Vergleich mit herkömmlichen Lösungen

| Feature | Google Analytics | Matomo Cloud | VGT Dattrack |
|---|---|---|---|
| **Self-Hosted** | ❌ | ❌ | ✅ |
| **Zero Dependencies** | ❌ | ❌ | ✅ |
| **Schrems II konform** | ❌ | ⚠️ | ✅ |
| **AES-256-GCM** | ❌ | ❌ | ✅ |
| **IP Zero-Knowledge** | ❌ | ⚠️ | ✅ |
| **O(1) Pagination** | n/a | ❌ | ✅ |
| **Key-Rotation** | n/a | ❌ | ✅ |
| **Anti-Replay** | ❌ | ❌ | ✅ |
| **Monatliche Kosten** | 0-€ (du zahlst mit Daten) | 19€+ | 0€ |

---

## 💰 Support the Project

[![Donate via PayPal](https://img.shields.io/badge/Donate-PayPal-00457C?style=for-the-badge&logo=paypal)](https://www.paypal.com/paypalme/dergoldenelotus)

| Method | Address |
|---|---|
| **PayPal** | [paypal.me/dergoldenelotus](https://www.paypal.com/paypalme/dergoldenelotus) |
| **Bitcoin** | `bc1q3ue5gq822tddmkdrek79adlkm36fatat3lz0dm` |
| **ETH** | `0xD37DEfb09e07bD775EaaE9ccDaFE3a5b2348Fe85` |
| **USDT (ERC-20)** | `0xD37DEfb09e07bD775EaaE9ccDaFE3a5b2348Fe85` |

---

## 🔗 VGT Ecosystem

| Tool | Typ | Zweck |
|---|---|---|
| 📊 **VGT Dattrack** | **Analytics** | Sovereign Analytics — Datenhoheit ohne Kompromisse |
| ⚔️ **[VGT Auto-Punisher](https://github.com/visiongaiatechnology/vgt-auto-punisher)** | **IDS** | L4+L7 Hybrid IDS — Angreifer werden terminiert bevor sie anklopfen |
| 🛡️ **VGT Sentinel** | **WAF** | 14-Modul WordPress Security Suite — Enterprise-Schutz |
| 🌐 **[VGT Global Threat Sync](https://github.com/visiongaiatechnology/vgt-global-threat-sync)** | **Preventive** | Bekannte Bedrohungen täglich blockieren bevor sie ankommen |
| 🔥 **[VGT Windows Firewall Burner](https://github.com/visiongaiatechnology/vgt-windows-burner)** | **Windows** | 280.000+ APT IPs in nativer Windows Firewall |

---

## 🏢 Built by VisionGaia Technology

[![VGT](https://img.shields.io/badge/VGT-VisionGaia_Technology-red?style=for-the-badge)](https://visiongaiatechnology.de)

VisionGaia Technology entwickelt Enterprise-grade Security und Analytics-Infrastruktur — engineered to the DIAMANT VGT SUPREME standard.

> *"Während andere deine Daten verkaufen, baut VGT Systeme in denen nur du deine Daten siehst."*

---

*Version 1.4.0 (Export Kernel) — VGT Dattrack // Sovereign Analytics Engine // Aegis Protocol // AES-256-GCM // Privacy by Design*
