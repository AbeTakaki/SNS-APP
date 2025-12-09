# DB Subnet Group

resource "aws_db_subnet_group" "this" {
  name = "${local.app_name}-db-subnet-group"
  subnet_ids = [
    aws_subnet.private_1a.id,
    aws_subnet.private_1c.id,
  ]
}