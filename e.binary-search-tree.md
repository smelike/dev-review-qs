
### Binary search trees

特点：

The tree additionally satisfies the binary search property, which states that the key in each node must be greater than or equal to any key stored in the left sub-tree, and less than or equal to any key stored in the right sub-tree.The leaves (final nodes) of the tree contain no key and have no structure to distinguish them from one another. 



If the tree is null, the key we are searching for does not exist in the tree. Otherwise, if the key equals that of the root, the search is successful and we return the node. If the key is less than that of the root, we search the left subtree. Similarly, if the key is greater than that of the root, we search the right subtree. This process is repeated until the key is found or the remaining subtree is null. If the searched key is not found after a null subtree is reached, then the key is not present in the tree. This is easily expressed as a recursive algorithm (implemented in Python): 

> node.key, node.right, node.left

```
def search_recursively (key, node):
	if node is None or node.key == key:
		return node
	if key < node.key:
		return search_recursively(key, node.left)
	# key > node.key
	return search_recursively(key, node.right)
```

> The same algorithm can be implemented iteratively:

```
	def search_iteratively(key, node):
		current_node = node
		while current_node is not None:
			if key == current_node.key:
				return current_node
			if key < current_node.key:
				current_node = current_node.left
			else: # key > current_node.key
				current_node = current_node.right
		return current_node
```

These two examples rely on the order relation being a total order.

If the order relation is only a total preorder, a reasonable extension of the functionality is the following: also in case of equality search down to the leaves in a direction specified by the user.

A binary tree sort equipped with such a comparison function become stable. 

Because in the worst case this algorithm must search from the root of the tree to the leaf farthest from the root, the search operation takes time proportional to the tree's height.

On average, binary search trees with n nodes have O(log n) height.

However, in the worst case, binary search trees can have O(n) height, when the unbalanced tree resembles a linked list (degenerate tree).
