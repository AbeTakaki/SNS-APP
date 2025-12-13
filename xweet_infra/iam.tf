# IAM user for Github Actions

resource "aws_iam_user" "github" {
  name = "${local.app_name}-github"
}

# IAM role for Github Actions

resource "aws_iam_role" "deployer" {
  name = "${local.app_name}-deployer"
  assume_role_policy = jsonencode({
    "Version":"2012-10-17"
    "Statement":[
      {
        "Effect":"Allow"
        "Principal":{
            "AWS": aws_iam_user.github.arn
        }
        "Action":[
            "sts:AssumeRole",
            "sts:TagSession"
        ]
      }
    ]
  })
}

# ECR policy for deployer

data "aws_iam_policy" "ecr_power_user" {
  arn = "arn:aws:iam::aws:policy/AmazonEC2ContainerRegistryPowerUser"
}

resource "aws_iam_role_policy_attachment" "role_deployer_policy_ecr_power_user" {
  role = aws_iam_role.deployer.name
  policy_arn = data.aws_iam_policy.ecr_power_user.arn
}