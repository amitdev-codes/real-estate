<template>
    <BreadcrumbAndPageTitle :pageTitle="'All Property Types'" />

    <!-- Content Grid -->
    <div class="grid lg:grid-cols-12 grid-cols-1 gap-6">

        <div class="lg:col-span-5">
            <!-- Propery Types Order Section -->
            <Card>
                <template #header>
                    Property Types
                </template>

                <Draggable ref="draggableTree" v-model="treeData" :max-level="3" virtualization class="block w-full xl:max-h-[700px] max-h-[500px]" data-simplebar
                    idKey="id" parentIdKey="parent_id"
                    @change="handleDrop"                    
                    >
                    <template #default="{ node }">

                        <div class="px-4 py-3 item-content w-full justify-between content-center"
                            :class="selectedPropertyType && selectedPropertyType.id === node.id ? 'bg-gray-100 dark:bg-gray-800' : ''">
                            <div class="item-content-left ps-8 content-stretch inline-flex w-full" >
                                <span class="text-slate-400 me-2 mdi-18px"><i :class="'mdi mdi-' + node.icon"></i></span>
                                <span class="text-slate-400 hover:text-green-600 cursor-pointer item-content-name"
                                    v-on:click="editPropertyType(node)"
                                    :class="selectedPropertyType && selectedPropertyType.id === node.id ? 'text-blue-600 font-semibold' : ''">
                                    {{ node.name }}
                                </span>
                            </div>

                            <div class="item-content-right">
                                <SuccessBadge v-if="node.is_active" :label="'Active'" />
                                <DangerBadge v-else :label="'Inactive'" />

                                <!-- <Link v-if="selectedPropertyType && selectedPropertyType.id === node.id"
                                    :href="route('admin.property-types.destroy', node.id)" method="delete"
                                    as="button" class="text-red-500 delete-action-button"
                                    @success="handleDeleteSuccess(node.id)">
                                    <i class="mdi mdi-delete-outline mdi-24px"></i>
                                </Link> -->

                                <button v-if="selectedPropertyType && selectedPropertyType.id === node.id"
                                    @click.prevent="handleDelete(node.id)" class="text-red-500 delete-action-button" >
                                    <i class="mdi mdi-delete-outline mdi-24px"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                </Draggable>


            </Card>
        </div>

        <div class="lg:col-span-7">
            <PropertyTypeForm :propertyType="selectedPropertyType" :icons="icons" />
        </div>
    </div>
</template>


<script setup>
import { ref, computed } from "vue";
import { Draggable } from '@he-tree/vue';
import { router } from '@inertiajs/vue3'
import { toast } from "vue3-toastify";
import { useDelete } from "@/utils/delete";


import '@he-tree/vue/style/default.css';
import '@he-tree/vue/style/material-design.css';


import BackendLayout from "@/layouts/backend-layout.vue";
import PropertyTypeForm from "../../components/property-type/property-type-form.vue";
import BreadcrumbAndPageTitle from "@backend-components/ui/breadcrumb-and-page-title.vue";

import Card from "@backend-components/ui/card.vue";
import SuccessBadge from "@backend-components/ui/badges/success-badge.vue";
import DangerBadge from "@backend-components/ui/badges/danger-badge.vue";

const props = defineProps({
    propertyTypes: Object,
    icons: Array
});

const draggableTree = ref(null)

const convertToTree = (items) => {
    const map = {}
    const roots = []

    items.forEach(item => {
        map[item.id] = {
            ...item,
            children: []
        }
    })

    items.forEach(item => {
        if (item.parent_id === null) {
            roots.push(map[item.id])
        } else {
            map[item.parent_id].children.push(map[item.id])
        }
    })

    return roots
}
const treeData = computed(() => convertToTree(props.propertyTypes))

const selectedPropertyType = ref(null);

const editPropertyType = (propertyType) => { 
    selectedPropertyType.value = propertyType; 
    // console.log(propertyType)
};

const handleDrop = () => {

    const changedTreeData = draggableTree.value.statsFlat;

    const flattenedData = changedTreeData.map((node, index) => {
        return {
            id: node.data.id,
            parent_id: node.parent ? node.parent.data.id : null,
            order_no: index + 1,
            // name: node.data.name
        };
    });

    router.post(route('admin.property-types.reorder'), { propertyTypes: flattenedData }, {
        forceFormData:true,
        onSuccess:()=>{
            toast.success('Property types reordered successfully')
        },
        onError:(errors) => {
            toast.error('Failed to reorder property types')
        }    
    })
}

const { deleteRow } = useDelete();

const handleDelete = (id) => {   
    deleteRow(`admin.property-types.destroy`, id );
    
    if (selectedPropertyType.value && selectedPropertyType.value.id === id) {
        selectedPropertyType.value = null;
    }
};

</script>

<script>
export default {
    layout: BackendLayout,
}
</script>

<style lang="scss" scoped>
.item-content {
    margin: .25rem 0;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    cursor: move;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
    position: relative;
    align-items: center;
}

.item-content-right{
    width:140px;
}

.delete-action-button{
    position: absolute;
    right: 0;
    padding-left: 0.5rem;
    padding-right: 0.5rem;
    top: 6px;
}

.item-content::before {
    color: rgb(100 116 139);
    content: "≡";
    display: block;
    font-size: 20px;
    font-weight: 400;
    left: 12px;
    position: absolute;
    text-indent: 0;
    top: 8px;
    padding-right: 12px;
    border-right: 1px solid #e2e8f0;
}

</style>
