# Env file Bucket and Policy

resource "aws_s3_bucket" "env_file" {
  bucket = "${local.identifier}-${local.app_name}-env-file"
}

resource "aws_iam_policy" "s3_env_file" {
  name = "${local.app_name}-env-file"
  policy = jsonencode(
    {
      "Version":"2012-10-17"
      "Statement":[
        {
          "Effect":"Allow"
          "Action":"s3:GetObject"
          "Resource":"${aws_s3_bucket.env_file.arn}/*"
        },
        {
          "Effect":"Allow"
          "Action":[
            "s3:GetBucketLocation",
            "s3:ListBucket",
          ]
          "Resource":aws_s3_bucket.env_file.arn
        }
      ]
    }
  )
}

resource "aws_iam_role_policy_attachment" "ecs_task_execution_s3_env_file" {
  role = aws_iam_role.ecs_task_execution_role.name
  policy_arn = aws_iam_policy.s3_env_file.arn
}