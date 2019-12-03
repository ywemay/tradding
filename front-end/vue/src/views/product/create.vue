<template>
    <product-editor :is-edit="true" />
</template>

<script>
import ProductEditor from './components/ProductEditor'

export default {
    name: 'CreateProduct',
    components: { ProductEditor },
}
</script>
