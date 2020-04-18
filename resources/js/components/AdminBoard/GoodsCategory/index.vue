<template>
  <div>
   <category-table></category-table>
   <category-dialog></category-dialog>
  </div>
</template>

<script>
import table from './GoodsCategoryTable'
import dialog from './GoodsCategoryDialog'

export default {
  components:{
    'category-table':table,
    'category-dialog':dialog
  }
}
</script>

