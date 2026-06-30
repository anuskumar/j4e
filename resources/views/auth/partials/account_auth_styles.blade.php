<style>
    body.account-page {
        background: #f4f6fb;
    }

    .auth-account-page {
        padding: 48px 0 72px;
    }

    .auth-account-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 16px 40px rgba(34, 30, 105, 0.1);
        border: 1px solid rgba(103, 29, 207, 0.08);
        overflow: hidden;
    }

    .auth-account-card__header {
        background: linear-gradient(90deg, rgba(34, 30, 105, 1) 5%, rgba(54, 8, 94, 1) 65%, rgba(103, 29, 207, 1) 100%);
        color: #fff;
        padding: 32px 32px 28px;
        text-align: center;
    }

    .auth-account-card__icon {
        width: 68px;
        height: 68px;
        margin: 0 auto 14px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.14);
        font-size: 28px;
    }

    .auth-account-card__header h1 {
        font-size: clamp(1.4rem, 3vw, 1.85rem);
        font-weight: 700;
        margin: 0 0 8px;
    }

    .auth-account-card__header p {
        margin: 0;
        color: rgba(255, 255, 255, 0.88);
        font-size: 14px;
        line-height: 1.6;
    }

    .auth-account-card__body {
        padding: 28px 32px 32px;
    }

    .auth-account-form .form-group label {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .auth-account-form .form-control {
        min-height: 46px;
        border-radius: 10px;
        border: 1px solid #d8dee9;
        padding: 10px 14px;
        font-size: 14px;
    }

    .auth-account-form .form-control:focus {
        border-color: #671dcf;
        box-shadow: 0 0 0 3px rgba(103, 29, 207, 0.12);
    }

    .auth-account-submit {
        width: 100%;
        background: linear-gradient(90deg, rgba(34, 30, 105, 1) 5%, rgba(103, 29, 207, 1) 100%);
        border: none;
        color: #fff;
        font-weight: 600;
        font-size: 16px;
        padding: 13px 28px;
        border-radius: 999px;
        margin-top: 8px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .auth-account-submit:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(103, 29, 207, 0.28);
    }

    .auth-account-footer {
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #eef1f6;
        text-align: center;
        font-size: 14px;
        color: #6b7280;
    }

    .auth-account-footer a,
    .auth-account-footer .btn-link {
        color: #671dcf;
        font-weight: 600;
        text-decoration: none;
    }

    .auth-account-footer a:hover,
    .auth-account-footer .btn-link:hover {
        color: #221e69;
        text-decoration: none;
    }

    .password-toggle-wrap {
        position: relative;
    }

    .password-toggle-wrap .form-control {
        padding-right: 44px;
    }

    .password-toggle-btn {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: transparent;
        color: #6c757d;
        padding: 0;
        line-height: 1;
        cursor: pointer;
        z-index: 2;
    }

    .password-toggle-btn:hover {
        color: #671dcf;
    }

    .password-toggle-btn:focus {
        outline: none;
    }

    @media (max-width: 767px) {
        .auth-account-page {
            padding: 28px 0 48px;
        }

        .auth-account-card__header,
        .auth-account-card__body {
            padding: 24px 20px;
        }
    }
</style>
