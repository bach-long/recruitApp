import React, { useState, useContext } from "react";
import { Row, Col, Input, Button, Image, Select } from "antd";
import imageLogin from "../../assets/image-login.jpeg";
import logoLogin from "../../assets/logo1.svg";
import RowVertical from "../../component/RowVertical";
import { role as ROLE } from "../../const";
import { loginService } from "../../service/Auth/index";
import { AuthContext } from "../../provider/authProvider";
import { toast } from "react-toastify";
import { useNavigate } from "react-router-dom";
import "./Auth.scss";
const Login = () => {
  const { authUser, setAuthUser } = useContext(AuthContext);
  const [role, setRole] = useState(0);
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const navigate = useNavigate();
  const handleChange = (value) => {
    setRole(value);
  };

  const handlerLogin = async () => {
    const data = {
      role: ROLE[role].label,
      email: email,
      password: password,
    };

    const res = await loginService(data);
    if (res.success === 1 && res.data && res.data.accessToken) {
      toast.success("Đăng nhập thành công!", 2);
      localStorage.setItem("accessToken", JSON.stringify(res.data.accessToken));
      setAuthUser(res.data.user);
      navigate("/");
    } else {
      toast.error("Tài khoản hoặc mật khẩu không chính xác");
    }
    console.log(res);
  };

  return (
    <Row className="auth-container">
      <Col className={"wrap-box"}>
        <Row style={{ paddingBottom: 20 }}>
          <Image height={80} preview={false} src={logoLogin} />
        </Row>
        <Row>
          <Col span={12} style={{ paddingRight: 40 }}>
            <Row>
              <Col span={24}>
                <RowVertical title={"Role"}>
                  <Select
                    style={{ marginBottom: 20, width: "100%" }}
                    options={ROLE}
                    defaultValue={role}
                    onChange={handleChange}
                  />
                </RowVertical>
                <RowVertical title={"Email"}>
                  <Input
                    style={{ marginBottom: 20 }}
                    onChange={(e) => setEmail(e.target.value)}
                  />
                </RowVertical>

                <RowVertical title={"Mật khẩu"}>
                  <Input
                    style={{ marginBottom: 20 }}
                    type={"password"}
                    onChange={(e) => {
                      setPassword(e.target.value);
                    }}
                  />
                </RowVertical>
              </Col>
            </Row>
            <Row
              style={{ paddingBottom: 15, color: "red", cursor: "pointer" }}
              onClick={() => {
                navigate("/forgot-password");
              }}
            >
              Quên mật khẩu
            </Row>
            <Row>
              <Col>
                <Button className="button-job" onClick={() => handlerLogin()}>
                  Login
                </Button>
              </Col>
            </Row>
            <Row style={{ paddingTop: 40 }}>
              <Col>
                <Row className="fs-20">Bạn chưa có tài khoản?</Row>
                <Row
                  style={{ cursor: "pointer", color: "var(--color-main)" }}
                  onClick={() => {
                    navigate("/signup");
                  }}
                >
                  Đăng ký tài khoản tại đây
                </Row>
              </Col>
            </Row>
          </Col>
          <Col span={12}>
            <Image src={imageLogin} preview={false} />
          </Col>
        </Row>
      </Col>
    </Row>
  );
};

export default Login;
