<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'addresses' => [
        'name' => 'Addresses',
        'index_title' => 'Addresses List',
        'new_title' => 'New Address',
        'create_title' => 'Create Address',
        'edit_title' => 'Edit Address',
        'show_title' => 'Show Address',
        'inputs' => [
            'address' => 'Address',
            'flat_number' => 'Flat Number',
            'floor' => 'Floor',
            'description' => 'Description',
        ],
    ],

    'cards' => [
        'name' => 'Cards',
        'index_title' => 'Cards List',
        'new_title' => 'New Card',
        'create_title' => 'Create Card',
        'edit_title' => 'Edit Card',
        'show_title' => 'Show Card',
        'inputs' => [
            'name' => 'Name',
            'cost' => 'Cost',
            'image' => 'Image',
        ],
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],

    'statuses' => [
        'name' => 'Statuses',
        'index_title' => 'Statuses List',
        'new_title' => 'New Status',
        'create_title' => 'Create Status',
        'edit_title' => 'Edit Status',
        'show_title' => 'Show Status',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'stages' => [
        'name' => 'Stages',
        'index_title' => 'Stages List',
        'new_title' => 'New Stage',
        'create_title' => 'Create Stage',
        'edit_title' => 'Edit Stage',
        'show_title' => 'Show Stage',
        'inputs' => [
            'name' => 'Name',
        ],
    ],


    'sources' => [
        'name' => 'Sources',
        'index_title' => 'Sources List',
        'new_title' => 'New Source',
        'create_title' => 'Create Source',
        'edit_title' => 'Edit Source',
        'show_title' => 'Show Source',
        'inputs' => [
            'name' => 'Name',
        ],
    ],



    'orders' => [
        'name' => 'Orders',
        'index_title' => 'Orders List',
        'new_title' => 'New Order',
        'create_title' => 'Create Order',
        'edit_title' => 'Edit Order',
        'show_title' => 'Show Order',
        'inputs' => [
            'customer_name' => 'Customer Name',
            'customer_phone' => 'Customer Phone',
            'customer_address' => 'Customer Address',
            'cost' => 'Cost',
            'order_date' => 'Order Date',
            'delivery_date' => 'Delivery Date',
            'status_id' => 'Status',
            'card_name' => 'Card Name',
            'lead_id' => 'Lead',
        ],
    ],

    'comments' => [
        'name' => 'Comments',
        'index_title' => 'Comments List',
        'new_title' => 'New Comment',
        'create_title' => 'Create Comment',
        'edit_title' => 'Edit Comment',
        'show_title' => 'Show Comment',
        'inputs' => [
            'comment' => 'Comment',
            'user_id' => 'User',
        ],
    ],

    'contracts' => [
        'name' => 'Contracts',
        'index_title' => 'Contracts List',
        'new_title' => 'New Contract',
        'create_title' => 'Create Contract',
        'edit_title' => 'Edit Contract',
        'show_title' => 'Show Contract',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'deals' => [
        'name' => 'Deals',
        'index_title' => 'Deals List',
        'new_title' => 'New Deal',
        'create_title' => 'Create Deal',
        'edit_title' => 'Edit Deal',
        'show_title' => 'Show Deal',
        'inputs' => [
            'customer_name' => 'Customer Name',
            'customer_phone' => 'Customer Phone',
            'customer_address' => 'Customer Address',
            'cost' => 'Cost',
            'deal_date' => 'Deal Date',
            'delivery_date' => 'Delivery Date',
            'cards' => 'Cards',
            'lead_id' => 'Lead',
        ],
    ],

    'leads' => [
        'name' => 'Leads',
        'index_title' => 'Leads List',
        'new_title' => 'New Lead',
        'create_title' => 'Create Lead',
        'edit_title' => 'Edit Lead',
        'show_title' => 'Show Lead',
        'inputs' => [
            'name' => 'Name',
            'address'=>'Address',
            'phone' => 'Phone',
            'phone2' => 'Phone2',
            'stage_id' => 'Stage',
            'user_id' => 'User',
            'source_id' => 'Source',
            'follow_date' => 'Follow Up',
            'create_date' => 'Create',
            'contract_id' => 'Contract',
            'card_id' => 'Card',
            'delivery' => 'Delivery',
            'user' => 'User',
            'source' => 'Source',
            'deliveryboy' => 'Delivery Boy',

        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];
