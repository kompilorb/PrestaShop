# PrestaShop API

## How to create a new route

### 1/ Declare your route
You must declare your route in one of the files in:
`src/PrestaShopBundle/Resources/config/api/routing_xxx.yml`.

If the file corresponding to your context does not exist, you can create it by taking care to declare your new route file in:
`src/PrestaShopBundle/Resources/config/routing_api.yml`

Examples, you want a route which show you list of warehouse available: in `src/PrestaShopBundle/Resources/config/api/routing_warehouse.yml`, add (if it does not exists)
```yml
_api_warehouse:
  resource: "api/routing_warehouse.yml"
```
Then, create a file named `src/PrestaShopBundle/Resources/config/api/routing_warehouse.yml` and add your route:
```yml
api_warehouse_list_warehouses:
    path: /warehouses
    methods: [GET]
    defaults:
        _controller: prestashop.core.api.warehouse.controller:listWarehousesAction

```

### 2/ Create your controller
1) API controllers are on the folder: `src/PrestaShopBundle/Controller/Api/xxxController.php`.
For our example, create `src/PrestaShopBundle/Controller/Api/WarehouseController.php` if not exists.

2) Register your controller in the `services.yml` localized in: `src/PrestaShopBundle/Resources/config/services.yml`
 Like others API controllers. (search `# Api - Controllers`), you need to register with the same `id` you put on your routing_xxx.yml (here, `prestashop.core.api.warehouse.controller`).

3) Extends your controller with `ApiController`, then you should be able to use the Symfony container in your container.

4) All your functions must return a `JsonResponse`.

5) Please, be simple, small controllers (using Services if you need).

### 3/ Create Entities, Repositories and Services! (Optional)
Please, do not use Legacy PrestaShop classes, create your own Service related with your context (here, Warehouse for example). Like your controllers, register them in the `services.yml`.
Your controller must be really simple, for the same warehouse example, we can imagine something like this:

```php
public function listWarehousesAction()
{
    $warehouses = $this->warehouseRepository->getWarehouse($tree = true);
    return new JsonResponse($warehouses, 200);
}
```

And put your logic into the repository. If the logic is more complicated or not related with en entity, use services.

### 4/ JSON return nomenclature
We have 2 cases:
1) Simple list of data, return like:
```php
$result = array(
    'data' => array(
        array(
            'id' => 1,
            'name' => 'Example 1',
        ),
        array(
            'id' => 2,
            'name' => 'Example 2',
        )
    )
);
```

2) A recursive data (for example, a tree), you must have a `tree` and `children` keys, return like:
```php
$result = array(
    'tree' => array(
        array(
            'id' => 1,
            'name' => 'Example 1',
            'children' => array(
                array(
                    'id' => 11,
                    'name' => 'Children 1.1',
                ),
                array(
                    'id' => 12,
                    'name' => 'Children 1.2',
                )
            )
        ),
        array(
            'id' => 2,
            'name' => 'Example 2',
            'children' => array(
                array(
                    'id' => 21,
                    'name' => 'Children 2.1',
                ),
                array(
                    'id' => 22,
                    'name' => 'Children 2.2',
                )
            )
        )
    )
);
```
