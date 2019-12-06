<template>
  <product-editor :is-edit="false" />
</template>

<script>
import ProductEditor from './components/ProductEditor'

export default {
  name: 'CreateProduct',
  components: { ProductEditor }
}
</script>
