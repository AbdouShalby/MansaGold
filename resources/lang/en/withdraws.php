<?php

return [
    'title' => 'Withdrawals',
    'empty' => 'No withdrawals found',
    'table' => [
        'id' => 'ID',
        'name' => 'Investor Name',
        'amount' => 'Withdrawal Amount',
        'status' => [
            'title' => 'Withdrawal Status',
            'waiting' => 'Pending',
            'canceled' => 'Rejected',
            'approved' => 'Approved'
        ],
        'created' => 'Request Date',
        'actions' => [
            'approve' => 'Approve',
            'cancel' => 'Reject',
        ],
    ],
];
