<?php

return [
    'title' => 'عمليات السحب',
    'empty' => 'لا يوجد عمليات سحب',
    'table' => [
        'id' => 'رقم',
        'name' => 'اسم المستثمر',
        'amount' => 'قيمة السحب',
        'status' => [
            'title' => 'حالة السحب',
            'waiting' => 'في انتظار الرد',
            'canceled' => 'تم الرفض',
            'approved' => 'تم القبول'
        ],
        'created' => 'تاريخ الطلب',
        'actions' => [
            'approve' => 'قبول',
            'cancel' => 'رفض',
        ],
    ],
];
