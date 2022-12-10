<?php
namespace Yipnyap;

class UserRelationship {
    public $RelationshipStatus;
    public string $InitiatorID;
    public string $TargetID;

    /**
     * Configure relationship initiator and target.
     */
    function SetRelationshipInfo($initiator, $target): void
    {
        $this->InitiatorID = $initiator;
        $this->TargetID = $target;
    }

    /**
     * Get relationship status.
     */
    function GetRelationshipInfo(): array
    {
        $this->RelationshipStatus = 'none';
        if ($this->IsFollowing()) {
            $this->RelationshipStatus = 'following';
        }

        return [
            'initiator' => $this->InitiatorID,
            'target' => $this->TargetID,
            'status' => $this->RelationshipStatus,
        ];
    }

    /**
     * Create follow
     */
    function CreateFollow(): bool
    {
        return bp_follow_start_following([
            'leader_id' => $this->TargetID,
            'follower_id' => $this->InitiatorID
        ]);
    }

    /**
     * Remove follow
     */
    function RemoveFollow(): bool
    {
        return bp_follow_stop_following([
            'leader_id' => $this->TargetID,
            'follower_id' => $this->InitiatorID
        ]);
    }

    /**
     * Check if user is following another user
     */
    function IsFollowing(): bool
    {
        return bp_follow_is_following([
            'leader_id' => $this->TargetID,
            'follower_id' => $this->InitiatorID
        ]);
    }

    /**
     * Check if users are mutuals (following each other)
     */
    function IsMutual(): bool
    {
        $Target = bp_follow_is_following([
            'leader_id' => $this->TargetID,
            'follower_id' => $this->InitiatorID
        ]);
        $Initiator = bp_follow_is_following([
            'leader_id' => $this->InitiatorID,
            'follower_id' => $this->TargetID
        ]);

        return $Target && $Initiator;
    }
}