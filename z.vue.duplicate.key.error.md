> vue error


----

```

Vue warn]: Duplicate keys detected: '0'. This may caused update error.

```



----

### How to fix this issue.

You could avoid this error by adding some prefix / suffix

```

<template v-for="it in items">
    <li :key="it.id + '-label'">{{it.label}}</li>
    <li :key="it.id + '-separator'" class="separator">&gt;</li>
</template>

```