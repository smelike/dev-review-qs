### Hash table 

> @20190827 - 
[Hash-Table](https://en.wikipedia.org/wiki/Hash_table)

In computing, a hash table (hash map) is a data structure that implements an associative array abstract data type, a structuce can map keys to valuees.


A hash table uses a hash function to compute an index into an array of buckets or slots, from which the desired value can be found.


Ideally, the hash function will assign each key to a unique bucket, but most hash table designs employ an imperfect hash function, which cause hash collisions where the hash function generates the same index for more than one key.

Such collisions must be accommodated in some way.

In a well-dimensioned hash table, the average cost (number of instructions) fro each lookup is independent of the number of elements stored in the tables.


Many hash table design also allow arbitrary insertions and deletions of key-valu pairs, at constant average cost per operation.

In many situations, hash tables turn out to be on average more efficient than search trees or any other table lookup structure.

For this reason, they are widely used in many kinds of computer software, particularly for associative arrays, database indexing, caches, and sets.



> Hashing

The idea of hashing is to distribute the entries (key/vealue pairs) across an array of buckets. Given a key, the algorithm computes an index that suggests where the entry can be found:

```
index = f(keyu, array_size)
```

Often this is done in two steps:

```
hash = hashfunc(key)
index = hash % array_size

```

In this method, the hash is independent of the array size, and it is reduced to an index (a number between 0 and array_size -1) useing the modulo operator(%).


In the case that the array size is power of two, the remainder operation is reduced to masking, which improves speed, but can increase problems with a poor has function.


> Choosing a hash function 

A good hash function and implementaion algorithm are essential for good hash table performance, but may be difficult to achieve.

A basic requirement is that the function should provide a uniform distribution of hash values. 

A non-uniform distribution increases the number of collisions and the cost of resolving them.

Uniformity is sometimes difficult to ensure by design, but may be evaluated empirically using statistical test, e.g., a Pearson's chi-squared test for discrete uniform distributions.


The distribution need to be uniform only for table sizes that occur in the application. 

In particular, if one uses dynamic resizing with exact doubling and halving of the table size, then the hash function needs to be uniform only when the size is a power of two. (2^n) 

Here the index can be computed as some range of bits of the has function.

On the other hand, some hashing algorithms prefer to have the size be a prime number.


The modulous operation may provide some additional mixing; this is especially useful with a poor hash function.

For open addressing schemes, the hash function should also avoid clustering, the mapping of two or more keys to consecutive slots.

Such clustering may cause the lookup cost to skyrocket, even if the load factor is low and collisions are infrequent.

The popular multiplicative hash is claimed to have particularly poor clustering behavior.


Cryptographic hash functions are believed to provide hash functions for any table size, either by modulo reduction or by bit masking.

They may also be appropriate if there is a risk of malicious users trying to sabotage a network service by submitting requests designed to generate a large number of collisions in the server's hash tables.


However, the risk of sabotage can also be avoided by cheapter methods(such as applying a secret salt to the data, or using a universal hash function).

A drawback of cryptographic hashing functions is that they are often slower to compute, which means that in cases where the uniformity for any size is not necessary, a non-cryptographic hashing function might be preferable.



> Perfect hash function

If all keys are known ahead of time, a perfect hash function can be used to create a perfect hash table that has no collisions.

If minimal perfect hashing is used, every location in the hash table can be used as well.

Perfect hasing allows for constant time lookups in all cases. This is in contrast to most chaining and open addressing methods, where the time for lookup is slow on average, but many be very large, O(n), for instance when all the keys hash to a few values.



> Key statistics

A critical staticstic for a hash table is the load factor, defined as 

```
 load factor = n / k,
```

where 

- n is the number of entries occupied in the hash table.

- k is the number of buckets.


As the load factor grows larger, the hash table becomes slower, and it may even fail to work (depending on the method used).

The expected constant time properly of a hash table assumes that the load factor be kept below some bound.

For a fixed number of buckets, the time for a lookup grows with the number of entries, and therefore the desire
