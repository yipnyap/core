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
    function GetRelationshipInfo($skipFollowCheck = false): array
    {
        $this->RelationshipStatus = [];
        if ($this->IsFollowing() && !$skipFollowCheck) {
            $this->RelationshipStatus[] = 'following';
        }

        $friendRequests = $this->GetFriendRequests();
        $friendRequestsReceived = $this->GetReceivedFriendRequests();
        if (in_array($this->InitiatorID, $friendRequests)) {
            $this->RelationshipStatus[] = 'pending';
        } else if (in_array($this->TargetID, $friendRequests)) {
            $this->RelationshipStatus[] = 'awaiting_response';
        } else if (in_array($this->InitiatorID, $friendRequestsReceived)) {
            $this->RelationshipStatus[] = 'awaiting_response';
        } else if (in_array($this->TargetID, $friendRequestsReceived)) {
            $this->RelationshipStatus[] = 'pending';
        } else if ($this->IsFriend()) {
            $this->RelationshipStatus[] = 'is_friend';
        }

        return [
            'initiator' => $this->InitiatorID,
            'target' => $this->TargetID,
            'status' => join('|', $this->RelationshipStatus),
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
        $friends = $this->GetFriends();
        return in_array($this->TargetID, $friends);
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
     * Get received friend requests
     * @return array
     * @since hk16-hf2
     */
    function GetReceivedFriendRequests(): array
    {
        $requests = [];
        $friend_requests = yipnyap_get_friend_requests_received($this->InitiatorID);
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
        $relationship = $this->GetRelationshipInfo(true);
        if ($relationship['status'] !== '') {
            return false;
        } else {
            return friends_add_friend($this->InitiatorID, $this->TargetID);
        }
    }

    /**
     * Get all friends
     * @return array
     * @since hk16-hf2
     */
    function GetFriends(): array
    {
        $friend_args = [
            'per_page' => 0,
            'page' => 0,
            'filter' => ''
        ];

        // $friend_args = array_replace($friend_args, $args);

        $friends = friends_get_alphabetically($this->InitiatorID, $friend_args['per_page'], $friend_args['page'], $friend_args['filter']);
        $f = [];

        foreach ($friends['users'] as $friend) {
            $f[] = $friend->ID;
        }

        return $f;
    }
}