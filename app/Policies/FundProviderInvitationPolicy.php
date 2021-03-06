<?php

namespace App\Policies;

use App\Models\Fund;
use App\Models\FundProviderInvitation;
use App\Models\Organization;
use Illuminate\Auth\Access\HandlesAuthorization;

class FundProviderInvitationPolicy
{
    use HandlesAuthorization;

    /**
     * @param string|null $identity_address
     * @param Fund $fund
     * @param Organization $organization
     * @return bool
     */
    public function indexSponsor(
        ?string $identity_address,
        Fund $fund,
        Organization $organization
    ) {
        if ($fund->organization_id != $organization->id) {
            return false;
        }

        return $organization->identityCan($identity_address, [
            'manage_providers', 'manage_funds'
        ]);
    }

    /**
     * @param string|null $identity_address
     * @param FundProviderInvitation $fundProviderInvitation
     * @param Fund $fund
     * @param Organization $organization
     * @return bool
     */
    public function showSponsor(
        ?string $identity_address,
        FundProviderInvitation $fundProviderInvitation,
        Fund $fund,
        Organization $organization
    ) {
        if ($fund->organization_id != $organization->id) {
            return false;
        }

        if ($fundProviderInvitation->fund_id != $fund->id) {
            return false;
        }

        return $organization->identityCan($identity_address, [
            'manage_providers', 'manage_funds'
        ]);
    }

    /**
     * @param string|null $identity_address
     * @param Fund $fromFund
     * @param Fund $fund
     * @param Organization $organization
     * @return bool
     */
    public function storeSponsor(
        ?string $identity_address,
        Fund $fromFund,
        Fund $fund,
        Organization $organization
    ) {
        if ($fund->organization_id != $fromFund->organization_id) {
            return false;
        }

        if ($fund->organization_id != $organization->id) {
            return false;
        }

        return $organization->identityCan($identity_address, [
            'manage_providers', 'manage_funds'
        ]);
    }

    /**
     * Determine whether the user can view the fund provider invitation.
     *
     * @param string|null $identity_address
     * @param FundProviderInvitation $fundProviderInvitation
     * @return bool
     */
    public function showByToken(
        ?string $identity_address,
        FundProviderInvitation $fundProviderInvitation
    ) {
        return isset($identity_address) && !empty($fundProviderInvitation);
    }

    /**
     * Determine whether the user can accept the fund provider invitation.
     *
     * @param string|null $identity_address
     * @param FundProviderInvitation $fundProviderInvitation
     * @return bool
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function acceptFundProviderInvitation(
        ?string $identity_address,
        FundProviderInvitation $fundProviderInvitation
    ) {
        if ($fundProviderInvitation->state == FundProviderInvitation::STATE_ACCEPTED) {
            $this->deny("Invitation already approved!");
        }

        if ($fundProviderInvitation->state == FundProviderInvitation::STATE_EXPIRED) {
            $this->deny("Invitation expired!");
        }

        return isset($identity_address) &&
            $fundProviderInvitation->state == FundProviderInvitation::STATE_PENDING;
    }
}
