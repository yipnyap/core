import React from 'react';

import FormInput from './FormInput';
import FormDatepicker from './FormDatepicker';
import FormInputRadioList from './FormInputRadioList';
import FormInputSelect from './FormInputSelect';
import FormInputCheckboxList from './FormInputCheckboxList';
import FormInputURL from './FormInputURL';
import FormTextarea from './FormTextarea';

import { getURLIcon } from '../utils/xprofile';

function FormRow(props) {
  return (
    <div className={`form-row ${props.modifiers || ''}`}>
      {
        props.data.map((field) => {
          let Input = FormInput,
              icon = getURLIcon(field.name),
              modifiers = 'small';

          if (field.type === 'textarea') {
            Input = FormTextarea;
            modifiers += ' mid-textarea';
          } else if (field.type === 'datebox') {
            Input = FormDatepicker;
          } else if (field.type === 'url') {
            Input = FormInputURL;
          } else if (field.type === 'checkbox') {
            Input = FormInputCheckboxList;
          } else if (field.type === 'radio') {
            Input = FormInputRadioList;
          } else if (field.type === 'selectbox') {
            Input = FormInputSelect;
          }

          return (
            <div key={field.name} className="form-item">
              <Input  label={field.name}
                      name={field.name.toLowerCase()}
                      description={field.description}
                      value={field.value}
                      meta={field.meta}
                      options={field.options}
                      icon={icon}
                      modifiers={modifiers}
                      handleValue={props.handleValue}
                      onChange={(data) => {props.onFieldUpdate(field, data);}}
              />
            </div>
          );
        })
      }
    </div>
  );
}

export { FormRow as default };
