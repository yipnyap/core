<?php
namespace Yipnyap;

class UserRelationship {
    public $RelationshipStatus;
    public string $InitiatorID;
    public string $TargetID;

    /**
     * Configure relationship initiator and target.
     */
    function SetRelationshipInfo($initiator, $target = 0): void
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

        // Loop through array, match ID
        $friendRequests = $this->GetFriendRequests();
        foreach ($friendRequests as $friendRequest) {
            if ($friendRequest['id'] === $this->TargetID) {
                $this->RelationshipStatus = 'friend_request_sent';
            }
        }

        if ($this->IsFriend()) {
            $this->RelationshipStatus = 'friend';
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

    /**
     * Check if users are friends
     * @return bool
     * @since hk15
     */
    function IsFriend(): bool
    {
        return friends_check_friendship($this->InitiatorID, $this->TargetID);
    }

    /**
     * Get friend requests
     */
    function GetFriendRequests(): array
    {
        $requests = [];
        $friend_requests = yipnyap_get_friend_requests_sent($this->InitiatorID);
        foreach ($friend_requests as $request) {
            $requests[] = [
                'id' => $request->id,
            ];
        }

        return $requests;
    }
    /**
     * Create a friend request
     */
    function CreateFriendRequest(): bool
    {
        return friends_add_friend($this->InitiatorID, $this->TargetID);
    }
}