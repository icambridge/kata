package main

import (
  "fmt"
)

type Node struct {
  Right *Node
  Left *Node
  Value string
}

func main() {
  tree := buildTree()
  tranverseInOrder(tree)
}

func tranverseInOrder(node *Node) {
  if node.Right != nil {
    tranverseInOrder(node.Right)
  }
  fmt.Println(node.Value)
  if node.Left != nil {
    tranverseInOrder(node.Left)
  }
}

func buildTree() *Node {
  return &Node{
        Right: &Node{
          Right: &Node {
            Value: "a",
          },
          Left: &Node{
            Right: &Node{Value: "c"},
            Left: &Node{Value: "e"},
            Value: "d",
          },
          Value: "b",
        },
        Left: &Node{
          Right: &Node{
            Left: &Node{
              Right: &Node{Value: "h"},
              Value: "i",
            },
            Value: "g",
          },
        },
        Value: "f",
  }
}
