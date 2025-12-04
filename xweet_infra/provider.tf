provider "aws" {
  region = "ap-northeast-1"
  # windows powershellにて
  # $env:AWS_PROFILE="profile名"
  # profile = ""
}

terraform{
  required_providers {
    aws={
      source = "hashicorp/aws"
      version = "5.100.0"
    }
  }
}