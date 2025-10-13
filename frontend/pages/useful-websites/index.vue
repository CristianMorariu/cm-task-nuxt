<script setup></script>
<template>
  <div>Usefull</div>

  <Table v-if="dataTable" :data="dataTable">
    <!-- ✅ slot pentru header -->
    <template #thead>
      <th class="px-4 py-2">ID</th>
      <th class="px-4 py-2">Name</th>
      <th class="px-4 py-2">Email</th>
    </template>

    <!-- ✅ slot pentru rânduri -->
    <template #row="{ row }">
      <td class="px-4 py-2">{{ row.id }}</td>
      <td class="px-4 py-2">{{ row.name }}</td>
      <td class="px-4 py-2">{{ row.email }}</td>
    </template>
  </Table>
</template>

<style lang="scss" scoped></style>
