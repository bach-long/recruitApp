import React from "react";
import { Form } from "antd";
import "./Recruit.scss";
import FormRecruit from "./FormRecruit";
import { postTask } from "../../../service/Company";
import { toast } from "react-toastify";
import { useContext } from "react";
import { AuthContext } from "../../../provider/authProvider";
const Recruit = () => {
  const { authUser } = useContext(AuthContext);
  const [form] = Form.useForm();
  const handleSubmit = async () => {
    try {
      await form.validateFields();
      const data = form.getFieldsValue();
      data.end = data.end.format("YYYY-MM-DD");
      data.start = data.start.format("YYYY-MM-DD");
      const res = await postTask({
        hr_id: authUser?.id,
        company_id: authUser.company_id,
        ...data,
      });
      if (res.success === 1) {
        toast.success("Đăng bài thành công");
        form.resetFields();
      } else {
        toast.error("Có lỗi xảy ra");
      }
    } catch (error) {
      toast.error("Có lỗi xảy ra");
    }
  };
  return (
    <Form className="form-recruit" form={form}>
      <FormRecruit onSubmit={handleSubmit} />
    </Form>
  );
};

export default Recruit;
