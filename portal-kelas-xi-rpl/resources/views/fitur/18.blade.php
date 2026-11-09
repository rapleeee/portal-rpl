@extends('layouts.app')

@section('title', 'Perangkat Lab Komputer – Inventaris Lab')

@push('styles')
<style>
    /* Scope Reset & Layout Enhancement for Fitur 18 */
    main#konten {
        width: min(1360px, calc(100% - 32px));
        padding-block: 20px 48px;
    }

    :root {
        --lab-amber: #f59e0b;
        --lab-amber-dark: #d97706;
        --lab-amber-light: #fef3c7;
        --lab-amber-active: #fcd34d;
        --lab-bg: #faf7f2;
        --lab-card-bg: #ffffff;
        --lab-text-main: #1e293b;
        --lab-text-muted: #64748b;
        --lab-border: #f1e7d8;
        --lab-border-subtle: #f8f1e7;
    }

    .lab-app-container {
        display: flex;
        gap: 24px;
        font-family: inherit;
        color: var(--lab-text-main);
    }

    /* Left Sidebar */
    .lab-sidebar {
        width: 250px;
        min-width: 250px;
        background: #fffdfa;
        border: 1px solid var(--lab-border);
        border-radius: 20px;
        padding: 28px 18px 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 4px 20px rgba(217, 119, 6, 0.04);
        position: relative;
        overflow: hidden;
    }

    .lab-sidebar-bottom-curve {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 120px;
        pointer-events: none;
        z-index: 0;
        opacity: 0.85;
    }

    .lab-sidebar-inner {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .lab-brand {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        margin-bottom: 28px;
    }

    .lab-logo-box {
        width: 64px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        color: var(--lab-amber);
    }

    .lab-brand h2 {
        font-size: 1.05rem;
        font-weight: 800;
        letter-spacing: 0.05em;
        line-height: 1.25;
        margin: 0;
        color: #1e293b;
    }

    .lab-brand-tagline {
        font-size: 0.72rem;
        color: #78716c;
        margin-top: 6px;
        letter-spacing: 0.02em;
    }

    .lab-nav {
        display: flex;
        flex-direction: column;
        gap: 8px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .lab-nav-item button,
    .lab-nav-item a {
        display: flex;
        align-items: center;
        gap: 14px;
        width: 100%;
        padding: 11px 16px;
        border-radius: 12px;
        border: none;
        background: transparent;
        font-size: 0.92rem;
        font-weight: 600;
        color: #475569;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: left;
    }

    .lab-nav-item button:hover,
    .lab-nav-item a:hover {
        background: #fef9ee;
        color: var(--lab-amber-dark);
    }

    .lab-nav-item.active button,
    .lab-nav-item.active a {
        background: var(--lab-amber-active);
        color: #1c1917;
        font-weight: 750;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.2);
    }

    .lab-sidebar-footer {
        margin-top: auto;
        padding-top: 40px;
        position: relative;
        z-index: 1;
        text-align: center;
    }

    .lab-sidebar-footer p {
        font-size: 0.8rem;
        font-style: italic;
        color: #857564;
        margin: 0;
        line-height: 1.4;
    }

    /* Main Content Area */
    .lab-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 20px;
        min-width: 0;
    }

    /* Topbar */
    .lab-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .lab-search-top {
        position: relative;
        width: 320px;
    }

    .lab-search-top svg {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        pointer-events: none;
    }

    .lab-search-top input {
        width: 100%;
        padding: 9px 14px 9px 38px;
        border-radius: 9999px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        font-size: 0.88rem;
        color: #1e293b;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .lab-search-top input:focus {
        border-color: var(--lab-amber);
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15);
    }

    .lab-user-actions {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .lab-notif-btn {
        position: relative;
        background: transparent;
        border: none;
        padding: 8px;
        border-radius: 50%;
        cursor: pointer;
        color: #334155;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }

    .lab-notif-btn:hover {
        background: #f1f5f9;
    }

    .lab-notif-badge {
        position: absolute;
        top: 3px;
        right: 4px;
        background: #ef4444;
        color: white;
        font-size: 0.65rem;
        font-weight: 750;
        width: 16px;
        height: 16px;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #ffffff;
    }

    .lab-profile-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        background: transparent;
        border: none;
        cursor: pointer;
        padding: 4px 8px 4px 4px;
        border-radius: 9999px;
        transition: background 0.2s;
    }

    .lab-profile-btn:hover {
        background: #f8fafc;
    }

    .lab-avatar {
        width: 36px;
        height: 36px;
        border-radius: 9999px;
        background: #fed7aa;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9a3412;
        overflow: hidden;
    }

    .lab-avatar svg {
        width: 24px;
        height: 24px;
    }

    .lab-user-name {
        font-size: 0.92rem;
        font-weight: 600;
        color: #1e293b;
    }

    /* Hero Banner */
    .lab-hero {
        position: relative;
        border-radius: 20px;
        background: linear-gradient(110deg, #fffbeb 0%, #fef3c7 40%, #fde68a 85%, #fcd34d 100%);
        padding: 28px 36px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 20px rgba(217, 119, 6, 0.08);
        border: 1px solid #fef08a;
    }

    .lab-hero-text {
        position: relative;
        z-index: 2;
        max-width: 580px;
    }

    .lab-hero-title {
        font-size: 1.85rem;
        font-weight: 800;
        color: #1c1917;
        margin: 0 0 6px 0;
        line-height: 1.2;
        letter-spacing: -0.02em;
    }

    .lab-hero-subtitle {
        font-size: 0.96rem;
        color: #475569;
        margin: 0;
        font-weight: 500;
    }

    .lab-hero-visual {
        position: relative;
        z-index: 1;
        width: 360px;
        height: 130px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .lab-hero-art {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    /* Stat Cards Row */
    .lab-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .lab-stat-card {
        background: var(--lab-card-bg);
        border: 1px solid #f1f5f9;
        border-radius: 18px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 18px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .lab-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
    }

    .lab-stat-icon-wrap {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .icon-total {
        background: #fef3c7;
        color: #d97706;
    }

    .icon-baik {
        background: #dcfce7;
        color: #16a34a;
    }

    .icon-perbaikan {
        background: #ffedd5;
        color: #ea580c;
    }

    .icon-rusak {
        background: #fee2e2;
        color: #dc2626;
    }

    .lab-stat-info {
        display: flex;
        flex-direction: column;
    }

    .lab-stat-value {
        font-size: 1.85rem;
        font-weight: 800;
        line-height: 1;
        color: #0f172a;
    }

    .lab-stat-label {
        font-size: 0.82rem;
        color: #64748b;
        margin-top: 4px;
        font-weight: 550;
    }

    /* Table Section Card */
    .lab-table-card {
        background: var(--lab-card-bg);
        border: 1px solid #f1f5f9;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .lab-table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .lab-table-title-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .lab-table-title-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #fef3c7;
        color: #d97706;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lab-table-title-group h3 {
        font-size: 1.25rem;
        font-weight: 750;
        margin: 0;
        color: #1e293b;
    }

    .btn-tambah-perangkat {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f59e0b;
        color: #1c1917;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 0.88rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.25);
    }

    .btn-tambah-perangkat:hover {
        background: #d97706;
        color: #ffffff;
        transform: translateY(-1px);
    }

    /* Controls Bar: Rows per page, Search, Filter */
    .lab-table-controls {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
    }

    .lab-control-left {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.88rem;
        color: #475569;
    }

    .lab-select-perpage {
        padding: 6px 28px 6px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E") no-repeat right 8px center;
        background-size: 14px;
        appearance: none;
        font-size: 0.86rem;
        font-weight: 600;
        color: #1e293b;
        cursor: pointer;
        outline: none;
    }

    .lab-control-right {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .lab-table-search {
        position: relative;
        width: 260px;
    }

    .lab-table-search svg {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }

    .lab-table-search input {
        width: 100%;
        padding: 7px 12px 7px 34px;
        border-radius: 9999px;
        border: 1px solid #cbd5e1;
        font-size: 0.85rem;
        outline: none;
        color: #1e293b;
        background: #ffffff;
        transition: border-color 0.2s;
    }

    .lab-table-search input:focus {
        border-color: var(--lab-amber);
    }

    .btn-filter-trigger {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 7px 16px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 0.85rem;
        font-weight: 600;
        color: #334155;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-filter-trigger:hover,
    .btn-filter-trigger.active {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
    }

    /* Filter dropdown box */
    .lab-filter-dropdown {
        display: none;
        padding: 14px 18px;
        background: #fefce8;
        border: 1px solid #fef08a;
        border-radius: 12px;
        gap: 16px;
        flex-wrap: wrap;
        align-items: center;
    }

    .lab-filter-dropdown.show {
        display: flex;
    }

    .lab-filter-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.84rem;
        font-weight: 600;
        color: #713f12;
    }

    .lab-filter-select {
        padding: 5px 12px;
        border-radius: 6px;
        border: 1px solid #fde047;
        background: #ffffff;
        font-size: 0.84rem;
        color: #1e293b;
    }

    /* Table Component */
    .lab-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .lab-inventory-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.88rem;
    }

    .lab-inventory-table thead tr {
        background: #fef3c7;
    }

    .lab-inventory-table th {
        padding: 13px 14px;
        font-weight: 700;
        font-size: 0.86rem;
        color: #1e293b;
        text-align: left;
        border-top: 1px solid #fde68a;
        border-bottom: 1px solid #fde68a;
        white-space: nowrap;
    }

    .lab-inventory-table th:first-child {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
        border-left: 1px solid #fde68a;
        width: 48px;
        text-align: center;
    }

    .lab-inventory-table th:last-child {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        border-right: 1px solid #fde68a;
        text-align: center;
        width: 120px;
    }

    .lab-inventory-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s;
    }

    .lab-inventory-table tbody tr:hover {
        background: #fffdf5;
    }

    .lab-inventory-table td {
        padding: 14px 14px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .lab-inventory-table td:first-child {
        text-align: center;
        font-weight: 600;
        color: #64748b;
    }

    .lab-inventory-table td:last-child {
        text-align: center;
    }

    .td-nama {
        font-weight: 650;
        color: #0f172a;
    }

    .td-kode {
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        font-size: 0.84rem;
        color: #475569;
        font-weight: 550;
    }

    /* Badges */
    .badge-kondisi {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 9999px;
        font-size: 0.78rem;
        font-weight: 700;
        line-height: 1.2;
    }

    .badge-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .badge-kondisi.kondisi-baik {
        background: #dcfce7;
        color: #15803d;
    }

    .badge-kondisi.kondisi-baik .badge-dot {
        background: #22c55e;
    }

    .badge-kondisi.kondisi-perbaikan {
        background: #ffedd5;
        color: #c2410c;
    }

    .badge-kondisi.kondisi-perbaikan .badge-dot {
        background: #f97316;
    }

    .badge-kondisi.kondisi-rusak {
        background: #fee2e2;
        color: #b91c1c;
    }

    .badge-kondisi.kondisi-rusak .badge-dot {
        background: #ef4444;
    }

    /* Action Buttons in Table */
    .lab-action-group {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        justify-content: center;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: transform 0.15s, opacity 0.15s;
    }

    .btn-action:hover {
        transform: scale(1.08);
    }

    .btn-action-view {
        background: #fef3c7;
        color: #78350f;
    }

    .btn-action-edit {
        background: #fef3c7;
        color: #78350f;
    }

    .btn-action-delete {
        background: #fee2e2;
        color: #dc2626;
    }

    /* Pagination / Footer of Table */
    .lab-table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        padding-top: 8px;
    }

    .lab-page-info {
        font-size: 0.85rem;
        color: #64748b;
    }

    .lab-pagination {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .lab-page-btn {
        min-width: 34px;
        height: 34px;
        padding: 0 8px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #334155;
        font-size: 0.85rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s;
    }

    .lab-page-btn:hover:not(:disabled) {
        border-color: #cbd5e1;
        background: #f8fafc;
    }

    .lab-page-btn.active {
        background: #f59e0b;
        color: #ffffff;
        border-color: #f59e0b;
    }

    .lab-page-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .lab-page-ellipsis {
        padding: 0 4px;
        color: #94a3b8;
        font-weight: 600;
    }

    /* Modals */
    .lab-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.45);
        backdrop-filter: blur(3px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 16px;
    }

    .lab-modal-backdrop.show {
        display: flex;
    }

    .lab-modal {
        background: #ffffff;
        width: 100%;
        max-width: 540px;
        border-radius: 18px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        animation: modalSlide 0.2s ease-out;
    }

    @keyframes modalSlide {
        from {
            opacity: 0;
            transform: scale(0.96) translateY(8px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .lab-modal-header {
        padding: 18px 24px;
        background: #fffbeb;
        border-bottom: 1px solid #fef08a;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .lab-modal-header h4 {
        margin: 0;
        font-size: 1.15rem;
        font-weight: 750;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .lab-modal-close {
        background: transparent;
        border: none;
        color: #64748b;
        cursor: pointer;
        padding: 4px;
        border-radius: 6px;
        display: flex;
    }

    .lab-modal-close:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .lab-modal-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        max-height: 75vh;
        overflow-y: auto;
    }

    .lab-form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .lab-form-group label {
        font-size: 0.82rem;
        font-weight: 650;
        color: #334155;
    }

    .lab-form-group input,
    .lab-form-group select,
    .lab-form-group textarea {
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 0.88rem;
        color: #0f172a;
        outline: none;
        font-family: inherit;
    }

    .lab-form-group input:focus,
    .lab-form-group select:focus,
    .lab-form-group textarea:focus {
        border-color: var(--lab-amber);
        box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.2);
    }

    .lab-form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .lab-modal-footer {
        padding: 16px 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-secondary {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #334155;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.86rem;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-secondary:hover {
        background: #f1f5f9;
    }

    .btn-primary {
        background: #f59e0b;
        border: none;
        color: #1c1917;
        padding: 8px 18px;
        border-radius: 8px;
        font-size: 0.86rem;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-primary:hover {
        background: #d97706;
        color: #ffffff;
    }

    .btn-danger {
        background: #ef4444;
        border: none;
        color: #ffffff;
        padding: 8px 18px;
        border-radius: 8px;
        font-size: 0.86rem;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    /* Detail View List */
    .lab-detail-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .lab-detail-row {
        display: flex;
        justify-content: space-between;
        padding-bottom: 8px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.88rem;
    }

    .lab-detail-label {
        color: #64748b;
        font-weight: 500;
    }

    .lab-detail-value {
        font-weight: 650;
        color: #0f172a;
        text-align: right;
    }

    /* Toast Notification */
    .lab-toast {
        position: fixed;
        bottom: 24px;
        right: 24px;
        background: #0f172a;
        color: #ffffff;
        padding: 12px 20px;
        border-radius: 10px;
        font-size: 0.86rem;
        font-weight: 600;
        display: none;
        align-items: center;
        gap: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        z-index: 10000;
        animation: toastFade 0.2s ease-in;
    }

    .lab-toast.show {
        display: flex;
    }

    .lab-toast svg {
        color: #22c55e;
    }

    @keyframes toastFade {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 1100px) {
        .lab-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .lab-sidebar {
            width: 210px;
            min-width: 210px;
        }
    }

    @media (max-width: 860px) {
        .lab-app-container {
            flex-direction: column;
        }
        .lab-sidebar {
            width: 100%;
            min-width: 100%;
        }
        .lab-hero-visual {
            display: none;
        }
    }

    @media (max-width: 580px) {
        .lab-stats-grid {
            grid-template-columns: 1fr;
        }
        .lab-table-controls {
            flex-direction: column;
            align-items: stretch;
        }
        .lab-control-right {
            flex-direction: column;
            align-items: stretch;
        }
        .lab-table-search {
            width: 100%;
        }
        .lab-form-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
@php
    // Integrasi Controller data: Jika Controller belum dipanggil dari routes, instansiasi otomatis
    $controller = app(\App\Http\Controllers\PerangkatLabController::class);
    $devicesData = $devices ?? $controller->getDeviceData();
    $statsData = $stats ?? $controller->getStatistics($devicesData);
@endphp

<div class="lab-app-container" id="labAppRoot">
    <!-- SIDEBAR KIRI -->
    <aside class="lab-sidebar" aria-label="Navigasi Inventaris Lab">
        <!-- SVG Latar Belakang Gelombang Emas di Bagian Bawah Sidebar -->
        <svg class="lab-sidebar-bottom-curve" viewBox="0 0 250 120" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,70 C60,115 150,40 250,90 L250,120 L0,120 Z" fill="#fef3c7" opacity="0.6"/>
            <path d="M0,90 C80,50 180,110 250,80 L250,120 L0,120 Z" fill="#fde68a" opacity="0.4"/>
            <path d="M0,105 C100,85 160,115 250,100 L250,120 L0,120 Z" fill="#f59e0b" opacity="0.15"/>
        </svg>

        <div class="lab-sidebar-inner">
            <!-- Brand / Logo -->
            <div class="lab-brand">
                <div class="lab-logo-box">
                    <!-- SVG Ikon Laptop / Komputer Lab Emas -->
                    <svg width="48" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="12" rx="2"></rect>
                        <line x1="2" y1="20" x2="22" y2="20"></line>
                        <line x1="8" y1="16" x2="16" y2="16"></line>
                        <circle cx="12" cy="10" r="2" fill="currentColor" opacity="0.2"></circle>
                    </svg>
                </div>
                <h2>LAB KOMPUTER<br><span style="color: #475569; font-size: 0.95rem; font-weight: 700;"></span></h2>
                <span class="lab-brand-tagline">Inventaris &bull; Terawat &bull; Siap Pakai</span>
            </div>

            <!-- Menu Navigasi Sidebar -->
            <ul class="lab-nav" role="menu">
                <li class="lab-nav-item active" role="none">
                    <button type="button" role="menuitem">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                        Dashboard
                    </button>
                </li>
                <li class="lab-nav-item" role="none">
                    <button type="button" role="menuitem" onclick="filterByCategory('')">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="14" rx="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                        Perangkat Lab
                    </button>
                </li>
                <li class="lab-nav-item" role="none">
                    <button type="button" role="menuitem" onclick="openAddModal()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Tambah Perangkat
                    </button>
                </li>
                <li class="lab-nav-item" role="none">
                    <button type="button" role="menuitem" onclick="showToast('Riwayat inventaris terbaru telah dimuat')">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        Riwayat
                    </button>
                </li>
                <li class="lab-nav-item" role="none">
                    <button type="button" role="menuitem" onclick="showToast('Laporan inventaris siap diekspor')">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="20" x2="18" y2="10"></line>
                            <line x1="12" y1="20" x2="12" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="14"></line>
                        </svg>
                        Laporan
                    </button>
                </li>
                <li class="lab-nav-item" role="none">
                    <button type="button" role="menuitem" onclick="showToast('Menu pengaturan sistem dibuka')">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                        </svg>
                        Pengaturan
                    </button>
                </li>
            </ul>

            <!-- Tagline Bawah Sidebar -->
            <div class="lab-sidebar-footer">
                <p>Kelola Inventaris<br>Lab dengan Mudah</p>
            </div>
        </div>
    </aside>

    <!-- KONTEN UTAMA DASHBOARD -->
    <section class="lab-main">
        <!-- Top Bar: Pencarian Global, Notifikasi & Profil Admin -->
        <header class="lab-topbar">
            <div class="lab-search-top">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" id="globalSearchInput" placeholder="Cari perangkat..." oninput="handleSearch(this.value)">
            </div>

            <div class="lab-user-actions">
                <button type="button" class="lab-notif-btn" aria-label="Notifikasi (2 baru)" onclick="showToast('2 notifikasi: Jadwal perawatan berkala dan pembaruan inventaris.')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="lab-notif-badge">2</span>
                </button>

                <div class="lab-profile-btn" role="button" tabindex="0">
                    <div class="lab-avatar">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <span class="lab-user-name">Admin</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="color: #64748b;">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div>
            </div>
        </header>

        <!-- Hero Banner Emas / Kuning Hangat -->
        <div class="lab-hero">
            <div class="lab-hero-text">
                <h1 class="lab-hero-title">Perangkat Lab Komputer</h1>
                <p class="lab-hero-subtitle">Sistem Informasi Inventaris Perangkat Laboratorium</p>
            </div>
            <div class="lab-hero-visual" aria-hidden="true">
                <!-- SVG Ilustrasi Ruang Lab Komputer Modern -->
                <svg class="lab-hero-art" viewBox="0 0 360 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="screenGrad" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#1e293b"/>
                            <stop offset="100%" stop-color="#0f172a"/>
                        </linearGradient>
                        <linearGradient id="deskGrad" x1="0" y1="0" x2="1" y2="0">
                            <stop offset="0%" stop-color="#d97706" stop-opacity="0.25"/>
                            <stop offset="100%" stop-color="#f59e0b" stop-opacity="0.4"/>
                        </linearGradient>
                    </defs>
                    <!-- Permukaan Meja Perspektif -->
                    <polygon points="20,118 360,118 360,82 110,82" fill="url(#deskGrad)"/>
                    <line x1="20" y1="118" x2="360" y2="118" stroke="#d97706" stroke-width="2" opacity="0.4"/>

                    <!-- Monitor 1 (Kiri Belakang) -->
                    <g transform="translate(130, 32) scale(0.65)">
                        <rect x="0" y="0" width="70" height="46" rx="4" fill="url(#screenGrad)"/>
                        <rect x="4" y="4" width="62" height="38" rx="2" fill="#38bdf8" opacity="0.35"/>
                        <rect x="30" y="46" width="10" height="16" fill="#475569"/>
                        <rect x="18" y="62" width="34" height="4" rx="2" fill="#64748b"/>
                    </g>

                    <!-- Monitor 2 (Tengah) -->
                    <g transform="translate(195, 22) scale(0.8)">
                        <rect x="0" y="0" width="74" height="48" rx="4" fill="url(#screenGrad)"/>
                        <rect x="5" y="5" width="64" height="38" rx="2" fill="#38bdf8" opacity="0.45"/>
                        <rect x="32" y="48" width="10" height="18" fill="#334155"/>
                        <rect x="19" y="66" width="36" height="5" rx="2" fill="#475569"/>
                    </g>

                    <!-- Monitor 3 (Kanan Depan - Dominan) -->
                    <g transform="translate(270, 8) scale(1)">
                        <rect x="0" y="0" width="82" height="54" rx="5" fill="url(#screenGrad)"/>
                        <rect x="5" y="5" width="72" height="44" rx="3" fill="#38bdf8" opacity="0.6"/>
                        <line x1="12" y1="16" x2="36" y2="16" stroke="#ffffff" stroke-width="2" stroke-linecap="round" opacity="0.8"/>
                        <line x1="12" y1="24" x2="48" y2="24" stroke="#ffffff" stroke-width="2" stroke-linecap="round" opacity="0.6"/>
                        <line x1="12" y1="32" x2="28" y2="32" stroke="#ffffff" stroke-width="2" stroke-linecap="round" opacity="0.4"/>
                        <rect x="35" y="54" width="12" height="22" fill="#1e293b"/>
                        <rect x="18" y="76" width="46" height="6" rx="3" fill="#334155"/>
                    </g>
                </svg>
            </div>
        </div>

        <!-- 4 Kartu Ringkasan Statistik -->
        <div class="lab-stats-grid">
            <!-- Card 1: Total Perangkat (48) -->
            <div class="lab-stat-card">
                <div class="lab-stat-icon-wrap icon-total">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="3" width="20" height="14" rx="2"></rect>
                        <line x1="8" y1="21" x2="16" y2="21"></line>
                        <line x1="12" y1="17" x2="12" y2="21"></line>
                    </svg>
                </div>
                <div class="lab-stat-info">
                    <span class="lab-stat-value" id="statTotalVal">{{ $statsData['total'] }}</span>
                    <span class="lab-stat-label">Total Perangkat</span>
                </div>
            </div>

            <!-- Card 2: Kondisi Baik (44) -->
            <div class="lab-stat-card">
                <div class="lab-stat-icon-wrap icon-baik">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <div class="lab-stat-info">
                    <span class="lab-stat-value" id="statBaikVal">{{ $statsData['baik'] }}</span>
                    <span class="lab-stat-label">Baik</span>
                </div>
            </div>

            <!-- Card 3: Perlu Perbaikan (3) -->
            <div class="lab-stat-card">
                <div class="lab-stat-icon-wrap icon-perbaikan">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                    </svg>
                </div>
                <div class="lab-stat-info">
                    <span class="lab-stat-value" id="statPerbaikanVal">{{ $statsData['perbaikan'] }}</span>
                    <span class="lab-stat-label">Perlu Perbaikan</span>
                </div>
            </div>

            <!-- Card 4: Rusak (1) -->
            <div class="lab-stat-card">
                <div class="lab-stat-icon-wrap icon-rusak">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
                <div class="lab-stat-info">
                    <span class="lab-stat-value" id="statRusakVal">{{ $statsData['rusak'] }}</span>
                    <span class="lab-stat-label">Rusak</span>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Perangkat Lab -->
        <div class="lab-table-card">
            <!-- Header Kartu Tabel: Judul & Tombol Tambah Perangkat -->
            <div class="lab-table-header">
                <div class="lab-table-title-group">
                    <div class="lab-table-title-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="14" rx="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                    </div>
                    <h3>Daftar Perangkat Lab</h3>
                </div>

                <button type="button" class="btn-tambah-perangkat" onclick="openAddModal()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Tambah Perangkat
                </button>
            </div>

            <!-- Baris Kontrol: Tampilkan Jumlah & Pencarian / Filter -->
            <div class="lab-table-controls">
                <div class="lab-control-left">
                    <span>Tampilkan</span>
                    <select class="lab-select-perpage" id="perPageSelect" onchange="changePerPage(this.value)">
                        <option value="5" selected>5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span>data</span>
                </div>

                <div class="lab-control-right">
                    <div class="lab-table-search">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="text" id="tableSearchInput" placeholder="Cari nama perangkat..." oninput="handleSearch(this.value)">
                    </div>

                    <button type="button" class="btn-filter-trigger" id="btnFilterTrigger" onclick="toggleFilterDropdown()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                        </svg>
                        Filter
                    </button>
                </div>
            </div>

            <!-- Dropdown Filter Tambahan (Kondisi & Kategori) -->
            <div class="lab-filter-dropdown" id="filterDropdown">
                <div class="lab-filter-item">
                    <span>Kondisi:</span>
                    <select class="lab-filter-select" id="filterKondisiSelect" onchange="applyFilters()">
                        <option value="">Semua Kondisi</option>
                        <option value="Baik">Baik</option>
                        <option value="Perlu Perbaikan">Perlu Perbaikan</option>
                        <option value="Rusak">Rusak</option>
                    </select>
                </div>
                <div class="lab-filter-item">
                    <span>Kategori:</span>
                    <select class="lab-filter-select" id="filterKategoriSelect" onchange="applyFilters()">
                        <option value="">Semua Kategori</option>
                        <option value="Komputer">Komputer</option>
                        <option value="Monitor">Monitor</option>
                        <option value="Aksesoris">Aksesoris</option>
                        <option value="Printer">Printer</option>
                        <option value="Multimedia">Multimedia</option>
                        <option value="Jaringan">Jaringan</option>
                        <option value="Power">Power</option>
                        <option value="Audio">Audio</option>
                        <option value="Peralatan">Peralatan</option>
                    </select>
                </div>
                <button type="button" class="btn-secondary" style="padding: 5px 12px; font-size: 0.82rem;" onclick="resetFilters()">Reset Filter</button>
            </div>

            <!-- Tabel Data -->
            <div class="lab-table-wrapper">
                <table class="lab-inventory-table" id="inventoryTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Perangkat</th>
                            <th>Kode Inventaris</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Kondisi</th>
                            <th>Lokasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="inventoryTableBody">
                        <!-- Dimuat secara dinamis via JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- Baris Informasi Paginasi & Kontrol Halaman -->
            <div class="lab-table-footer">
                <div class="lab-page-info" id="paginationInfo">
                    Menampilkan 1–5 dari {{ $statsData['total'] }} data
                </div>

                <div class="lab-pagination" id="paginationControls">
                    <!-- Tombol paginasi dinamis -->
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL: TAMBAH PERANGKAT -->
<div class="lab-modal-backdrop" id="modalAdd">
    <div class="lab-modal" role="dialog" aria-labelledby="modalAddTitle">
        <div class="lab-modal-header">
            <h4 id="modalAddTitle">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" style="color: #d97706;">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah Perangkat Baru
            </h4>
            <button type="button" class="lab-modal-close" onclick="closeModal('modalAdd')" aria-label="Tutup">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <form id="formAddDevice" onsubmit="saveNewDevice(event)">
            <div class="lab-modal-body">
                <div class="lab-form-group">
                    <label for="addNama">Nama Perangkat</label>
                    <input type="text" id="addNama" required placeholder="Contoh: Komputer PC">
                </div>
                <div class="lab-form-row">
                    <div class="lab-form-group">
                        <label for="addKode">Kode Inventaris</label>
                        <input type="text" id="addKode" required placeholder="Contoh: PC-002">
                    </div>
                    <div class="lab-form-group">
                        <label for="addKategori">Kategori</label>
                        <select id="addKategori" required>
                            <option value="Komputer">Komputer</option>
                            <option value="Monitor">Monitor</option>
                            <option value="Aksesoris">Aksesoris</option>
                            <option value="Printer">Printer</option>
                            <option value="Multimedia">Multimedia</option>
                            <option value="Jaringan">Jaringan</option>
                            <option value="Power">Power</option>
                            <option value="Audio">Audio</option>
                            <option value="Peralatan">Peralatan</option>
                        </select>
                    </div>
                </div>
                <div class="lab-form-row">
                    <div class="lab-form-group">
                        <label for="addJumlah">Jumlah Unit</label>
                        <input type="number" id="addJumlah" min="1" value="1" required>
                    </div>
                    <div class="lab-form-group">
                        <label for="addKondisi">Kondisi</label>
                        <select id="addKondisi" required>
                            <option value="Baik" selected>Baik</option>
                            <option value="Perlu Perbaikan">Perlu Perbaikan</option>
                            <option value="Rusak">Rusak</option>
                        </select>
                    </div>
                </div>
                <div class="lab-form-group">
                    <label for="addLokasi">Lokasi Ruang</label>
                    <input type="text" id="addLokasi" value="Lab Komputer" required>
                </div>
                <div class="lab-form-group">
                    <label for="addSpesifikasi">Spesifikasi / Catatan Teknis</label>
                    <textarea id="addSpesifikasi" rows="2" placeholder="Deskripsi spesifikasi komponen..."></textarea>
                </div>
            </div>
            <div class="lab-modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('modalAdd')">Batal</button>
                <button type="submit" class="btn-primary">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL: DETAIL PERANGKAT -->
<div class="lab-modal-backdrop" id="modalDetail">
    <div class="lab-modal" role="dialog" aria-labelledby="modalDetailTitle">
        <div class="lab-modal-header">
            <h4 id="modalDetailTitle">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #d97706;">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
                Detail Informasi Perangkat
            </h4>
            <button type="button" class="lab-modal-close" onclick="closeModal('modalDetail')" aria-label="Tutup">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <div class="lab-modal-body">
            <div class="lab-detail-list">
                <div class="lab-detail-row">
                    <span class="lab-detail-label">Nama Perangkat</span>
                    <span class="lab-detail-value" id="detailNama">-</span>
                </div>
                <div class="lab-detail-row">
                    <span class="lab-detail-label">Kode Inventaris</span>
                    <span class="lab-detail-value" id="detailKode" style="font-family: monospace;">-</span>
                </div>
                <div class="lab-detail-row">
                    <span class="lab-detail-label">Kategori</span>
                    <span class="lab-detail-value" id="detailKategori">-</span>
                </div>
                <div class="lab-detail-row">
                    <span class="lab-detail-label">Jumlah Unit</span>
                    <span class="lab-detail-value" id="detailJumlah">-</span>
                </div>
                <div class="lab-detail-row">
                    <span class="lab-detail-label">Kondisi Status</span>
                    <span class="lab-detail-value" id="detailKondisi">-</span>
                </div>
                <div class="lab-detail-row">
                    <span class="lab-detail-label">Lokasi Penempatan</span>
                    <span class="lab-detail-value" id="detailLokasi">-</span>
                </div>
                <div class="lab-detail-row">
                    <span class="lab-detail-label">Tahun Pengadaan</span>
                    <span class="lab-detail-value" id="detailTahun">-</span>
                </div>
                <div class="lab-detail-row">
                    <span class="lab-detail-label">Terakhir Dicek</span>
                    <span class="lab-detail-value" id="detailDicek">-</span>
                </div>
                <div class="lab-detail-row" style="flex-direction: column; gap: 4px; border-bottom: none;">
                    <span class="lab-detail-label">Spesifikasi Lengkap</span>
                    <span class="lab-detail-value" id="detailSpesifikasi" style="text-align: left; font-size: 0.85rem; background: #f8fafc; padding: 10px; border-radius: 8px;">-</span>
                </div>
            </div>
        </div>
        <div class="lab-modal-footer">
            <button type="button" class="btn-secondary" onclick="closeModal('modalDetail')">Tutup</button>
        </div>
    </div>
</div>

<!-- MODAL: EDIT PERANGKAT -->
<div class="lab-modal-backdrop" id="modalEdit">
    <div class="lab-modal" role="dialog" aria-labelledby="modalEditTitle">
        <div class="lab-modal-header">
            <h4 id="modalEditTitle">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #d97706;">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                Ubah Data Perangkat
            </h4>
            <button type="button" class="lab-modal-close" onclick="closeModal('modalEdit')" aria-label="Tutup">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <form id="formEditDevice" onsubmit="saveEditDevice(event)">
            <input type="hidden" id="editId">
            <div class="lab-modal-body">
                <div class="lab-form-group">
                    <label for="editNama">Nama Perangkat</label>
                    <input type="text" id="editNama" required>
                </div>
                <div class="lab-form-row">
                    <div class="lab-form-group">
                        <label for="editKode">Kode Inventaris</label>
                        <input type="text" id="editKode" required>
                    </div>
                    <div class="lab-form-group">
                        <label for="editKategori">Kategori</label>
                        <select id="editKategori" required>
                            <option value="Komputer">Komputer</option>
                            <option value="Monitor">Monitor</option>
                            <option value="Aksesoris">Aksesoris</option>
                            <option value="Printer">Printer</option>
                            <option value="Multimedia">Multimedia</option>
                            <option value="Jaringan">Jaringan</option>
                            <option value="Power">Power</option>
                            <option value="Audio">Audio</option>
                            <option value="Peralatan">Peralatan</option>
                        </select>
                    </div>
                </div>
                <div class="lab-form-row">
                    <div class="lab-form-group">
                        <label for="editJumlah">Jumlah (Unit)</label>
                        <input type="text" id="editJumlah" required>
                    </div>
                    <div class="lab-form-group">
                        <label for="editKondisi">Kondisi</label>
                        <select id="editKondisi" required>
                            <option value="Baik">Baik</option>
                            <option value="Perlu Perbaikan">Perlu Perbaikan</option>
                            <option value="Rusak">Rusak</option>
                        </select>
                    </div>
                </div>
                <div class="lab-form-group">
                    <label for="editLokasi">Lokasi Ruang</label>
                    <input type="text" id="editLokasi" required>
                </div>
                <div class="lab-form-group">
                    <label for="editSpesifikasi">Spesifikasi Teknis</label>
                    <textarea id="editSpesifikasi" rows="2"></textarea>
                </div>
            </div>
            <div class="lab-modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('modalEdit')">Batal</button>
                <button type="submit" class="btn-primary">Perbarui Data</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL: KONFIRMASI HAPUS -->
<div class="lab-modal-backdrop" id="modalDelete">
    <div class="lab-modal" style="max-width: 440px;" role="dialog" aria-labelledby="modalDeleteTitle">
        <div class="lab-modal-header" style="background: #fef2f2; border-color: #fee2e2;">
            <h4 id="modalDeleteTitle" style="color: #991b1b;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #dc2626;">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
                Konfirmasi Hapus Perangkat
            </h4>
            <button type="button" class="lab-modal-close" onclick="closeModal('modalDelete')" aria-label="Tutup">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <div class="lab-modal-body">
            <p style="margin: 0; font-size: 0.92rem; color: #475569;">
                Apakah Anda yakin ingin menghapus data perangkat <strong id="deleteTargetNama" style="color: #0f172a;"></strong> (<span id="deleteTargetKode"></span>) dari inventaris lab?
            </p>
            <input type="hidden" id="deleteTargetId">
        </div>
        <div class="lab-modal-footer">
            <button type="button" class="btn-secondary" onclick="closeModal('modalDelete')">Batal</button>
            <button type="button" class="btn-danger" onclick="executeDeleteDevice()">Hapus Data</button>
        </div>
    </div>
</div>

<!-- TOAST NOTIFIKASI FEEDBACK -->
<div class="lab-toast" id="labToast" role="status">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
        <polyline points="22 4 12 14.01 9 11.01"></polyline>
    </svg>
    <span id="toastMessage">Perubahan berhasil disimpan</span>
</div>
@endsection

@push('scripts')
<script>
    // Data State dari Controller
    let inventoryData = @json($devicesData);
    let currentPage = 1;
    let perPage = 5;
    let searchQuery = '';
    let selectedKondisi = '';
    let selectedKategori = '';

    // Icon SVGs
    const ICONS = {
        view: `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>`,
        edit: `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>`,
        trash: `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>`,
        prev: `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>`,
        next: `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>`
    };

    // Initialize View on DOM Ready
    document.addEventListener('DOMContentLoaded', () => {
        renderTable();
        updateStats();
    });

    // Helper: Hitung & Perbarui Kartu Ringkasan
    function updateStats() {
        const total = inventoryData.length;
        let baik = 0;
        let perbaikan = 0;
        let rusak = 0;

        inventoryData.forEach(item => {
            if (item.kondisi === 'Baik') baik++;
            else if (item.kondisi === 'Perlu Perbaikan') perbaikan++;
            else if (item.kondisi === 'Rusak') rusak++;
        });

        document.getElementById('statTotalVal').textContent = total;
        document.getElementById('statBaikVal').textContent = baik;
        document.getElementById('statPerbaikanVal').textContent = perbaikan;
        document.getElementById('statRusakVal').textContent = rusak;
    }

    // Helper: Filter data sesuai input pencarian dan seleksi kategori/kondisi
    function getFilteredData() {
        return inventoryData.filter(item => {
            const matchesSearch = searchQuery === '' ||
                item.nama.toLowerCase().includes(searchQuery.toLowerCase()) ||
                item.kode.toLowerCase().includes(searchQuery.toLowerCase()) ||
                item.kategori.toLowerCase().includes(searchQuery.toLowerCase()) ||
                item.lokasi.toLowerCase().includes(searchQuery.toLowerCase());

            const matchesKondisi = selectedKondisi === '' || item.kondisi === selectedKondisi;
            const matchesKategori = selectedKategori === '' || item.kategori === selectedKategori;

            return matchesSearch && matchesKondisi && matchesKategori;
        });
    }

    // Render Tabel Utama
    function renderTable() {
        const filtered = getFilteredData();
        const totalRows = filtered.length;
        const totalPages = Math.ceil(totalRows / perPage) || 1;

        if (currentPage > totalPages) {
            currentPage = totalPages;
        }

        const startIndex = (currentPage - 1) * perPage;
        const endIndex = Math.min(startIndex + perPage, totalRows);
        const pageItems = filtered.slice(startIndex, endIndex);

        const tbody = document.getElementById('inventoryTableBody');
        tbody.innerHTML = '';

        if (pageItems.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" style="text-align: center; padding: 36px; color: #94a3b8;">
                        Tidak ditemukan perangkat yang sesuai dengan kriteria pencarian.
                    </td>
                </tr>
            `;
        } else {
            pageItems.forEach((item, index) => {
                const tr = document.createElement('tr');

                // Class dan warna badge kondisi
                let badgeClass = 'kondisi-baik';
                if (item.kondisi === 'Perlu Perbaikan') {
                    badgeClass = 'kondisi-perbaikan';
                } else if (item.kondisi === 'Rusak') {
                    badgeClass = 'kondisi-rusak';
                }

                tr.innerHTML = `
                    <td>${startIndex + index + 1}</td>
                    <td class="td-nama">${escapeHtml(item.nama)}</td>
                    <td class="td-kode">${escapeHtml(item.kode)}</td>
                    <td>${escapeHtml(item.kategori)}</td>
                    <td>${escapeHtml(item.jumlah)}</td>
                    <td>
                        <span class="badge-kondisi ${badgeClass}">
                            <span class="badge-dot"></span>
                            ${escapeHtml(item.kondisi)}
                        </span>
                    </td>
                    <td>${escapeHtml(item.lokasi)}</td>
                    <td>
                        <div class="lab-action-group">
                            <button type="button" class="btn-action btn-action-view" onclick="openDetailModal(${item.id})" title="Lihat Spesifikasi">
                                ${ICONS.view}
                            </button>
                            <button type="button" class="btn-action btn-action-edit" onclick="openEditModal(${item.id})" title="Ubah Data">
                                ${ICONS.edit}
                            </button>
                            <button type="button" class="btn-action btn-action-delete" onclick="openDeleteModal(${item.id})" title="Hapus Perangkat">
                                ${ICONS.trash}
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        // Perbarui Info Paginasi
        const infoEl = document.getElementById('paginationInfo');
        if (totalRows === 0) {
            infoEl.textContent = 'Menampilkan 0 dari 0 data';
        } else {
            infoEl.textContent = `Menampilkan ${startIndex + 1}–${endIndex} dari ${totalRows} data`;
        }

        // Render Tombol Kontrol Paginasi
        renderPagination(totalPages);
    }

    // Render Kontrol Paginasi (Prev, Numbers, Ellipsis, Next)
    function renderPagination(totalPages) {
        const container = document.getElementById('paginationControls');
        container.innerHTML = '';

        // Tombol Sebelumnya (<)
        const prevBtn = document.createElement('button');
        prevBtn.type = 'button';
        prevBtn.className = 'lab-page-btn';
        prevBtn.innerHTML = ICONS.prev;
        prevBtn.disabled = currentPage === 1;
        prevBtn.onclick = () => goToPage(currentPage - 1);
        container.appendChild(prevBtn);

        // Nomor Halaman
        const maxVisibleButtons = 5;
        let startPage = 1;
        let endPage = totalPages;

        if (totalPages > 7) {
            if (currentPage <= 3) {
                endPage = 4;
            } else if (currentPage >= totalPages - 2) {
                startPage = totalPages - 3;
            } else {
                startPage = currentPage - 1;
                endPage = currentPage + 1;
            }
        }

        if (startPage > 1) {
            appendPageButton(container, 1);
            if (startPage > 2) {
                const el = document.createElement('span');
                el.className = 'lab-page-ellipsis';
                el.textContent = '...';
                container.appendChild(el);
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            appendPageButton(container, i);
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                const el = document.createElement('span');
                el.className = 'lab-page-ellipsis';
                el.textContent = '...';
                container.appendChild(el);
            }
            appendPageButton(container, totalPages);
        }

        // Tombol Selanjutnya (>)
        const nextBtn = document.createElement('button');
        nextBtn.type = 'button';
        nextBtn.className = 'lab-page-btn';
        nextBtn.innerHTML = ICONS.next;
        nextBtn.disabled = currentPage === totalPages || totalPages === 0;
        nextBtn.onclick = () => goToPage(currentPage + 1);
        container.appendChild(nextBtn);
    }

    function appendPageButton(container, pageNum) {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = `lab-page-btn ${pageNum === currentPage ? 'active' : ''}`;
        btn.textContent = pageNum;
        btn.onclick = () => goToPage(pageNum);
        container.appendChild(btn);
    }

    function goToPage(pageNum) {
        currentPage = pageNum;
        renderTable();
    }

    function changePerPage(val) {
        perPage = parseInt(val, 10);
        currentPage = 1;
        renderTable();
    }

    function handleSearch(val) {
        searchQuery = val;
        // Sinkronisasi input atas dan tabel jika ada
        const topInput = document.getElementById('globalSearchInput');
        const tblInput = document.getElementById('tableSearchInput');
        if (topInput && topInput.value !== val) topInput.value = val;
        if (tblInput && tblInput.value !== val) tblInput.value = val;

        currentPage = 1;
        renderTable();
    }

    function toggleFilterDropdown() {
        const el = document.getElementById('filterDropdown');
        const btn = document.getElementById('btnFilterTrigger');
        el.classList.toggle('show');
        btn.classList.toggle('active');
    }

    function applyFilters() {
        selectedKondisi = document.getElementById('filterKondisiSelect').value;
        selectedKategori = document.getElementById('filterKategoriSelect').value;
        currentPage = 1;
        renderTable();
    }

    function filterByCategory(cat) {
        selectedKategori = cat;
        document.getElementById('filterKategoriSelect').value = cat;
        currentPage = 1;
        renderTable();
        showToast(cat ? `Menampilkan kategori: ${cat}` : 'Menampilkan seluruh perangkat lab');
    }

    function resetFilters() {
        document.getElementById('filterKondisiSelect').value = '';
        document.getElementById('filterKategoriSelect').value = '';
        selectedKondisi = '';
        selectedKategori = '';
        currentPage = 1;
        renderTable();
        showToast('Filter telah direset');
    }

    // Modal Control Functions
    function openModal(id) {
        document.getElementById(id).classList.add('show');
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('show');
    }

    function openAddModal() {
        document.getElementById('formAddDevice').reset();
        openModal('modalAdd');
    }

    function saveNewDevice(e) {
        e.preventDefault();
        const nama = document.getElementById('addNama').value.trim();
        const kode = document.getElementById('addKode').value.trim();
        const kategori = document.getElementById('addKategori').value;
        const jumlahNum = parseInt(document.getElementById('addJumlah').value, 10) || 1;
        const kondisi = document.getElementById('addKondisi').value;
        const lokasi = document.getElementById('addLokasi').value.trim();
        const spesifikasi = document.getElementById('addSpesifikasi').value.trim() || 'Standar Ruang Praktik Lab';

        const newId = inventoryData.length > 0 ? Math.max(...inventoryData.map(d => d.id)) + 1 : 1;

        const newDevice = {
            id: newId,
            no: inventoryData.length + 1,
            nama: nama,
            kode: kode,
            kategori: kategori,
            jumlah: `${jumlahNum} unit`,
            jumlah_angka: jumlahNum,
            kondisi: kondisi,
            lokasi: lokasi,
            spesifikasi: spesifikasi,
            tahun_pengadaan: '2026',
            terakhir_dicek: 'Hari ini'
        };

        inventoryData.unshift(newDevice);
        closeModal('modalAdd');
        updateStats();
        renderTable();
        showToast(`Perangkat ${nama} berhasil ditambahkan`);
    }

    function openDetailModal(id) {
        const item = inventoryData.find(d => d.id === id);
        if (!item) return;

        document.getElementById('detailNama').textContent = item.nama;
        document.getElementById('detailKode').textContent = item.kode;
        document.getElementById('detailKategori').textContent = item.kategori;
        document.getElementById('detailJumlah').textContent = item.jumlah;
        document.getElementById('detailKondisi').textContent = item.kondisi;
        document.getElementById('detailLokasi').textContent = item.lokasi;
        document.getElementById('detailTahun').textContent = item.tahun_pengadaan || '2023';
        document.getElementById('detailDicek').textContent = item.terakhir_dicek || 'Terawat';
        document.getElementById('detailSpesifikasi').textContent = item.spesifikasi || 'Spesifikasi standar operasional laboratorium komputer.';

        openModal('modalDetail');
    }

    function openEditModal(id) {
        const item = inventoryData.find(d => d.id === id);
        if (!item) return;

        document.getElementById('editId').value = item.id;
        document.getElementById('editNama').value = item.nama;
        document.getElementById('editKode').value = item.kode;
        document.getElementById('editKategori').value = item.kategori;
        document.getElementById('editJumlah').value = item.jumlah;
        document.getElementById('editKondisi').value = item.kondisi;
        document.getElementById('editLokasi').value = item.lokasi;
        document.getElementById('editSpesifikasi').value = item.spesifikasi || '';

        openModal('modalEdit');
    }

    function saveEditDevice(e) {
        e.preventDefault();
        const id = parseInt(document.getElementById('editId').value, 10);
        const item = inventoryData.find(d => d.id === id);
        if (!item) return;

        item.nama = document.getElementById('editNama').value.trim();
        item.kode = document.getElementById('editKode').value.trim();
        item.kategori = document.getElementById('editKategori').value;
        item.jumlah = document.getElementById('editJumlah').value.trim();
        item.kondisi = document.getElementById('editKondisi').value;
        item.lokasi = document.getElementById('editLokasi').value.trim();
        item.spesifikasi = document.getElementById('editSpesifikasi').value.trim();
        item.terakhir_dicek = 'Hari ini';

        closeModal('modalEdit');
        updateStats();
        renderTable();
        showToast(`Data perangkat ${item.nama} berhasil diperbarui`);
    }

    function openDeleteModal(id) {
        const item = inventoryData.find(d => d.id === id);
        if (!item) return;

        document.getElementById('deleteTargetId').value = item.id;
        document.getElementById('deleteTargetNama').textContent = item.nama;
        document.getElementById('deleteTargetKode').textContent = item.kode;

        openModal('modalDelete');
    }

    function executeDeleteDevice() {
        const id = parseInt(document.getElementById('deleteTargetId').value, 10);
        const index = inventoryData.findIndex(d => d.id === id);
        if (index !== -1) {
            const nama = inventoryData[index].nama;
            inventoryData.splice(index, 1);
            closeModal('modalDelete');
            updateStats();
            renderTable();
            showToast(`Data perangkat ${nama} berhasil dihapus`);
        }
    }

    // Toast Feedback Notification
    let toastTimeout = null;
    function showToast(msg) {
        const toast = document.getElementById('labToast');
        const text = document.getElementById('toastMessage');
        text.textContent = msg;
        toast.classList.add('show');

        if (toastTimeout) clearTimeout(toastTimeout);
        toastTimeout = setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
</script>
@endpush
