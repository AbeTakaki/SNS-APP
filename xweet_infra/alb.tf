# ALB
resource "aws_lb" "this" {
  name="${local.app_name}-alb"
  load_balancer_type = "application"
  internal = false
  idle_timeout = 60
  subnets=[
    aws_subnet.public_1a.id,
    aws_subnet.public_1c.id,
  ]
  security_groups = [
    aws_security_group.web.id
  ]
}

# ALB Listener

resource "aws_lb_listener" "http" {
  load_balancer_arn = aws_lb.this.arn
  port = "80"
  protocol = "HTTP"
  default_action {
    type = "redirect"
    redirect {
      port = "443"
      protocol = "HTTPS"
      status_code = "HTTP_301"
    }
  }
}

resource "aws_lb_listener" "https" {
  load_balancer_arn = aws_lb.this.arn
  port = "443"
  protocol = "HTTPS"
  certificate_arn = aws_acm_certificate.root.arn
  default_action {
    type = "fixed-response"
    fixed_response {
      content_type = "text/plain"
      message_body = "503 Service Temporarily Unavailable"
      status_code = "503"
    }
  }
}