# Contributing to Free PMO

Thanks for considering to contribute to this project. Let's make it better.

> [Baca versi Bahasa Indonesia](CONTRIBUTING.id.md)

### Submit Issue
This project is still being developed. Most of the features have **Feature** or **Unit Testing**, but it is very likely that there are **bugs** that have missed the tests. If you find **bug** or **error** when you use this application, please [report Issue](https://github.com/nafiesl/free-pmo/issues/new) with subject **prefix: [BUG]**.

We try to minimize **errors** and **bugs** as much as possible.

> Before submitting an issue, you should look at the list of issues already reported by other contributors, your issue have been reported. :)

### New Feature Proposal
Basically Free PMO already includes basic features in project management (especially from a **freelancer** perspective). Very likely some features are added in the future. If you have an **idea** that you want proposed as a feature on this project, please suggest it by submit issue with **subject prefix: [PROPOSAL]**.

We will be happy to discuss it.

### Create new Pull Request

Wow, this part is a remarkable contribution, you have spent time and thoughts to help many people, thanks very much. There are some **Pull Request categories** that you can make :

#### 1. Bugfix

You help in the bugfix (error fixing) that reported by other contributors through Issue. If this bugfix is related **database interaction** (CRUD Operation) or **form submission**, please fulfill these requirements :

1. Create **tests**, related to fixed bug.
2. Make sure **all tests are passed** when you create **Pull Request** (assisted by [travis-ci](https://travis-ci.org)).

We will review your changes together. Just to make sure thare are no conflict that effect on existing features when your **Pull Request** are merged.

#### 2. Typo Fix

Very likely we have some typos on the software `web pages`, source code `comments`, `documentation` files, or on `lang` file that we use widely on the system. If you want to contribute to fix the **typo** on this project, please create new **Pull Request** to fix it, we will review it together.

#### 3. New Feature

This **Pull Request** will create **new feature** on Free PMO project. If you want to create this type of **Pull Request**, please be sure that you meet these requirements :

1. The new feature has been [proposed and discussed on **Issue**](#new-feature-proposal).
2. New features that has any **database interaction** or **form submission** requires **Feature Test** and/or **Unit Test**.
3. All **tests are passed** (assisted by [travis-ci](https://travis-ci.org)).

We will **review and test** your new feature **Pull Request** before it merged to master branch.

> ##### Notes
>
> If you **change** some **table structure** on new feature, just change corresponding **migration file** directly (since this project is still in development). **For example**: your new feature need have some `payments` table structure changes, just update `2016_11_15_151228_create_payments_table.php` migration file directly.
>
> Then **please** inform the **alter table sql script** (of table structure changes) through **commit comment** (like [this example](https://github.com/nafiesl/free-pmo/commit/a813524f680e9926d64f1006a1c615acf86c24f1#commitcomment-26166267)). So existing Free PMO users can update their table structure easily.

#### 4. Lang File

This type of **Pull Request** will add new **lang** files on `resources/lang` directory based on system `locale` configuration (eg: `lang/en` for English). Currenty, we have `lang` files only in `id` for Bahasa Indonesia and `en` for English.

If you are considering to create/add another language based on your locale or want to fix existing `lang` files. Please create new **Pull Request** so web can **review** it together.

### Donation

Just for reminder, Free PMO is free and open-sourced project management software under [MIT license](LICENSE). It doesn't matter if you want to **use or modify** this project for **private or commercial** purposes as long as you do not remove the [license](LICENSE) file from the project.

If you are considering to donate for this project development, you can send your donation via :

#### Bank Transfer (Indonesian Bank)

| Account Number | BCA // 7820088543 |
| --- | --- |
| Account Name | **Nafies Luthfi** |
| Transfer Code | 014 |

#### or

[![Support via PayPal](https://cdn.rawgit.com/twolfson/paypal-github-button/1.0.0/dist/button.svg)](https://www.paypal.me/nafiesl/)

Thank you, again, for considering to contribute for Free PMO project.

Best Regards,

<br>
Nafies Luthfi,
Free PMO Developer