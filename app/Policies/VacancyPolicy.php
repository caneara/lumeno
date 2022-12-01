<?php

namespace App\Policies;

use App\Models\User;
use App\Types\Policy;
use App\Models\Member;
use App\Models\Vacancy;
use App\Models\Organization;

class VacancyPolicy extends Policy
{
    /**
     * Determine whether the given user can archive the given vacancy.
     *
     */
    public function archive(User $user, Organization $organization, Vacancy $vacancy) : bool
    {
        return $vacancy->isNotArchived() &&
            $organization->owns($vacancy);
    }

    /**
     * Determine whether the given user can create vacancies.
     *
     */
    public function create(User $user, Member $member = null) : bool
    {
        return ! ! $member;
    }

    /**
     * Determine whether the given user can delete the given vacancy.
     *
     */
    public function delete(User $user, Organization $organization, Vacancy $vacancy) : bool
    {
        return $vacancy->isNotArchived() &&
            $vacancy->hasNotSentInvitations() &&
            $organization->owns($vacancy);
    }

    /**
     * Determine whether the given user can edit the given vacancy.
     *
     */
    public function edit(User $user, Organization $organization, Vacancy $vacancy) : bool
    {
        return $vacancy->isNotArchived() &&
            $vacancy->hasNotSentInvitations() &&
            $organization->owns($vacancy);
    }

    /**
     * Determine whether the given user can export the given vacancy.
     *
     */
    public function export(User $user, Organization $organization, Vacancy $vacancy) : bool
    {
        return $vacancy->hasSentInvitations() &&
            $organization->owns($vacancy);
    }

    /**
     * Determine whether the given user can show the given vacancy.
     *
     */
    public function show(User $user, Organization $organization, Vacancy $vacancy) : bool
    {
        $current = $vacancy?->requirements_count;

        if (blank($current)) {
            $current = $vacancy->requirements()->count();
        }

        $this->denyIf($current === 0, function() {
            return 'The vacancy must have at least one requirement';
        });

        return $organization->owns($vacancy);
    }

    /**
     * Determine whether the given user can store vacancies.
     *
     */
    public function store(User $user, Member $member = null) : bool
    {
        return ! ! $member;
    }

    /**
     * Determine whether the given user can update the given vacancy.
     *
     */
    public function update(User $user, Organization $organization, Vacancy $vacancy) : bool
    {
        return $vacancy->isNotArchived() &&
            $vacancy->hasNotSentInvitations() &&
            $organization->owns($vacancy);
    }

    /**
     * Determine whether the given user can view any vacancies.
     *
     */
    public function view(User $user, Member $member = null) : bool
    {
        return ! ! $member;
    }
}
