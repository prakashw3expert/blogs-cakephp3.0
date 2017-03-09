<?php
foreach ($menus as $key => $category) {
    $menus[$key] = json_decode($category, true);
}
?>
<script type="text/javascript">
    var categories = <?php echo json_encode($menus); ?>;
</script>

<div class="custom-dd dd hide" id="nestable_list_1">
    <ol class="dd-list">

        <li ng-repeat="(key, category) in categories" class="dd-item" data-id="{{category.id}}" nestable_directive>
            <div class="dd-handle" ng-click="addCategory(category.id, 0)">
                <i class="ion-ios7-circle-outline" ng-class="{ 'ion-ios7-circle-outline' : category.id != Blogs.category_id,'ion-ios7-checkmark-outline': category.id == Blogs.category_id}"></i>
                <i class="ion-ios7-checkmark-outline" ng-if="category.id == Blogs.parent_id || category.id == Blogs.category_id"></i>
                <span class="item-text" >
                    {{category.title}}
                </span>
            </div>


            <ol class="dd-list dd dd-nodrag" ng-if="category.child_categories">

                <li ng-repeat="(cKey, childCategory) in category.child_categories" class="dd-item" data-id="{{childCategory.id}}">
                    <div class="dd-handle" ng-click="addCategory(childCategory.id,childCategory.parent_id)">
                        <i class="ion-ios7-circle-outline" ng-class="{ 'ion-ios7-circle-outline' : childCategory.id != Blogs.category_id,'ion-ios7-checkmark-outline': childCategory.id == Blogs.category_id}"></i>
                        <span class="item-text">
                            {{childCategory.title}}
                        </span>
                    </div>
                </li>

            </ol>

        </li>

    </ol>
</div>
